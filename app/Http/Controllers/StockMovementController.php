<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status', true)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(5)
            ->withQueryString();

        return view('stock.index', compact('products'));
    }

    public function history(Request $request)
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when($request->search, function ($query, $search) {
                $query->where('product_name', 'like', "%{$search}%");
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->from, function ($query, $from) {
                $query->whereDate('date', '>=', $from);
            })
            ->when($request->to, function ($query, $to) {
                $query->whereDate('date', '<=', $to);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('stock.history', compact('movements'));
    }

    public function create()
    {
        $products = Product::where('status', true)->orderBy('name')->get();
        return view('stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'nullable|numeric|min:0',
            'reason' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'out' && $validated['quantity'] > $product->quantity) {
            return back()->withErrors(['quantity' => 'Not enough stock. Current stock: ' . $product->quantity])->withInput();
        }

        DB::transaction(function () use ($validated, $product) {
            if ($validated['type'] === 'in') {
                $unitCost = $validated['unit_cost'] ?? $product->buying_price;
                $incomingQuantity = $validated['quantity'];

                $remainingToShip = $this->resolveOversoldDebt($product, $incomingQuantity, $unitCost);

                if ($remainingToShip > 0) {
                    StockMovement::create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'user_id' => auth()->id(),
                        'type' => 'in',
                        'quantity' => $remainingToShip,
                        'unit_cost' => $unitCost,
                        'remaining_quantity' => $remainingToShip,
                        'reason' => $validated['reason'] ?? null,
                        'date' => $validated['date'],
                    ]);
                }

                $product->increment('quantity', $incomingQuantity);
                $product->update(['buying_price' => $unitCost]);
            } else {
                $product->consumeFifo($validated['quantity']);

                StockMovement::create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'user_id' => auth()->id(),
                    'type' => 'out',
                    'quantity' => $validated['quantity'],
                    'reason' => $validated['reason'] ?? null,
                    'date' => $validated['date'],
                ]);

                $product->decrement('quantity', $validated['quantity']);
            }
        });

        return redirect()->route('stock.index')->with('success', 'Stock movement recorded.');
    }

    private function resolveOversoldDebt(Product $product, int $incomingQuantity, float $unitCost): int
    {
        $remaining = $incomingQuantity;

        $debts = $product->saleItems()
            ->where('is_oversold', true)
            ->orderBy('created_at')
            ->get();

        foreach ($debts as $debt) {
            if ($remaining <= 0) break;

            if ($debt->oversold_quantity <= $remaining) {
                $verifiedPortionCost = $debt->total_cost - ($debt->oversold_quantity * $debt->oversold_unit_cost);
                $newOversoldPortionCost = $debt->oversold_quantity * $unitCost;

                $debt->update([
                    'total_cost' => $verifiedPortionCost + $newOversoldPortionCost,
                    'is_oversold' => false,
                ]);

                $remaining -= $debt->oversold_quantity;
            }
        }

        return $remaining;
    }
}