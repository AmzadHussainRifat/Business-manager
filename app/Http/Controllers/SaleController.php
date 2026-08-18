<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleItemBatch;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function history(Request $request)
    {
        $sales = Sale::with(['items.product', 'user'])
            ->when($request->from, function ($query, $from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($request->to, function ($query, $to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->when($request->min_amount, function ($query, $min) {
                $query->where('total_amount', '>=', $min);
            })
            ->when($request->max_amount, function ($query, $max) {
                $query->where('total_amount', '<=', $max);
            })
            ->when($request->oversold, function ($query) {
                $query->whereHas('items', function ($q) {
                    $q->where('is_oversold', true);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('sales.history', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('status', true)->orderBy('name')->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'required_with:customer_name|nullable|string|max:20',
            'discount_type' => 'nullable|in:flat,percent',
            'discount_value' => 'nullable|numeric|min:0',
        ]);

        $sale = null;

        DB::transaction(function () use ($validated, &$sale) {
            $subtotal = 0;
            $lines = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                $lineTotal = $product->selling_price * $item['quantity'];
                $subtotal += $lineTotal;

                $lines[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->selling_price,
                ];
            }

            $discountType = $validated['discount_type'] ?? null;
            $discountValue = $validated['discount_value'] ?? 0;
            $discountAmount = 0;

            if ($discountType === 'flat') {
                $discountAmount = min($discountValue, $subtotal);
            } elseif ($discountType === 'percent') {
                $discountAmount = $subtotal * (min($discountValue, 100) / 100);
            }

            $total = $subtotal - $discountAmount;

            $customerId = null;
            $normalizedPhone = null;

            if (! empty($validated['customer_phone'])) {
                $normalizedPhone = preg_replace('/[^0-9]/', '', $validated['customer_phone']);
                if (str_starts_with($normalizedPhone, '44')) {
                    $normalizedPhone = '0' . substr($normalizedPhone, 2);
                }

                $customer = Customer::firstOrCreate(
                    ['phone' => $normalizedPhone],
                    ['name' => $validated['customer_name'] ?? 'Walk-in customer']
                );
                $customerId = $customer->id;
            }

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'customer_id' => $customerId,
                'customer_name' => $validated['customer_name'] ?? null,
                'customer_phone' => $normalizedPhone ?? ($validated['customer_phone'] ?? null),
                'subtotal' => $subtotal,
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'total_amount' => $total,
            ]);

            foreach ($lines as $line) {
                $product = $line['product'];
                $consumption = $product->consumeFifo($line['quantity']);
                $totalCost = collect($consumption)->sum(fn($c) => $c['quantity'] * $c['unit_cost']);

                $fallbackEntry = collect($consumption)->first(fn($c) => $c['stock_movement_id'] === null);
                $isOversold = $fallbackEntry !== null;
                $oversoldQuantity = $fallbackEntry['quantity'] ?? null;
                $oversoldUnitCost = $fallbackEntry['unit_cost'] ?? null;

                $saleItem = SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'total_cost' => $totalCost,
                    'is_oversold' => $isOversold,
                    'oversold_quantity' => $oversoldQuantity,
                    'oversold_unit_cost' => $oversoldUnitCost,
                ]);

                foreach ($consumption as $batch) {
                    if ($batch['stock_movement_id'] !== null) {
                        SaleItemBatch::create([
                            'sale_item_id' => $saleItem->id,
                            'stock_movement_id' => $batch['stock_movement_id'],
                            'quantity' => $batch['quantity'],
                            'unit_cost' => $batch['unit_cost'],
                        ]);
                    }
                }

                $product->decrement('quantity', $line['quantity']);

                StockMovement::create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'user_id' => auth()->id(),
                    'type' => 'out',
                    'quantity' => $line['quantity'],
                    'reason' => 'Sale #' . $sale->id,
                    'date' => now()->toDateString(),
                ]);
            }
        });

        return redirect()->route('sales.index')->with('completedSale', [
            'id' => $sale->id,
            'total_amount' => $sale->total_amount,
            'items' => $sale->items->map(function ($item) {
                return [
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ];
            })->toArray(),
        ]);
    }
}