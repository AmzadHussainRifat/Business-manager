<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleItemBatch;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // --- Users ---
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => 'password123', 'role' => 'admin']
        );

        $staff1 = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            ['name' => 'Sam Carter', 'role' => 'staff', 'pin' => '123456', 'password' => 'unused-staff-password']
        );
        $staff2 = User::firstOrCreate(
            ['email' => 'staff2@example.com'],
            ['name' => 'Priya Shah', 'role' => 'staff', 'pin' => '111111', 'password' => 'unused-staff-password']
        );
        $staff3 = User::firstOrCreate(
            ['email' => 'staff3@example.com'],
            ['name' => 'Jordan Lee', 'role' => 'staff', 'pin' => '222222', 'password' => 'unused-staff-password']
        );
        $staffPool = [$staff1, $staff2, $staff3];

        // --- Expense categories ---
        $categoryNames = ['Rent', 'Utilities', 'Supplies', 'Marketing', 'Wages'];
        foreach ($categoryNames as $name) {
            ExpenseCategory::firstOrCreate(['name' => $name]);
        }

        // --- Products ---
        $productDefs = [
            ['A5 Notebook', 1.20, 3.50],
            ['Ballpoint Pen (Blue)', 0.15, 0.60],
            ['Ballpoint Pen (Black)', 0.15, 0.60],
            ['Stapler', 2.80, 6.99],
            ['Printer Paper (500 sheets)', 3.50, 7.99],
            ['Sticky Notes Pack', 0.90, 2.50],
            ['Ring Binder Folder', 1.10, 3.20],
            ['USB Drive 32GB', 4.00, 9.99],
            ['AA Batteries (4-pack)', 1.50, 4.50],
            ['Extension Cord 3m', 5.00, 12.99],
            ['Bottled Water 500ml', 0.30, 1.20],
            ['Instant Coffee Sachets (10)', 1.80, 4.00],
            ['Envelopes (Pack of 50)', 1.20, 3.00],
            ['Highlighter Set (4 colors)', 1.60, 4.20],
            ['Desk Lamp', 8.00, 19.99],
        ];

        $products = [];
        $code = 1;
        foreach ($productDefs as [$name, $buy, $sell]) {
            $products[] = Product::firstOrCreate(
                ['name' => $name],
                [
                    'product_code' => 'PRD-' . str_pad($code, 4, '0', STR_PAD_LEFT),
                    'buying_price' => $buy,
                    'selling_price' => $sell,
                    'status' => true,
                ]
            );
            $code++;
        }

        foreach ($products as $product) {
            if ($product->quantity > 0) continue;

            $initialQty = rand(15, 40);
            $stockDate = now()->subDays(rand(20, 25))->toDateString();

            StockMovement::create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'user_id' => $admin->id,
                'type' => 'in',
                'quantity' => $initialQty,
                'unit_cost' => $product->buying_price,
                'remaining_quantity' => $initialQty,
                'reason' => 'Initial stock',
                'date' => $stockDate,
            ]);

            $product->increment('quantity', $initialQty);
        }

        $target = $products[3]; // Stapler
        $target->update(['quantity' => 4]);
        DB::table('stock_movements')
            ->where('product_id', $target->id)
            ->where('type', 'in')
            ->update(['remaining_quantity' => 4]);

        $lowStock = $products[9]; // Extension Cord
        $lowStock->update(['quantity' => 3]);
        DB::table('stock_movements')
            ->where('product_id', $lowStock->id)
            ->where('type', 'in')
            ->update(['remaining_quantity' => 3]);

        // --- Customers ---
        $fakeCustomers = [
            ['name' => 'Alice Nguyen', 'phone' => '07700900001'],
            ['name' => 'Ben Okafor', 'phone' => '07700900002'],
            ['name' => 'Chloe Davies', 'phone' => '07700900003'],
            ['name' => 'Dev Patel', 'phone' => '07700900004'],
        ];

        // --- Sales over the last 30 days ---
        for ($i = 0; $i < 40; $i++) {
            $saleDate = now()->subDays(rand(0, 29))->setTime(rand(9, 18), rand(0, 59));
            $itemCount = rand(1, 4);
            $chosenProducts = collect($products)->random($itemCount);

            $subtotal = 0;
            $lines = [];
            foreach ($chosenProducts as $product) {
                $qty = rand(1, 3);
                if ($product->id === $target->id && $i === 5) {
                    $qty = 7;
                }
                $lines[] = ['product' => $product, 'quantity' => $qty, 'unit_price' => $product->selling_price];
                $subtotal += $product->selling_price * $qty;
            }

            $discountType = rand(1, 4) === 1 ? (rand(0, 1) ? 'flat' : 'percent') : null;
            $discountValue = $discountType === 'flat' ? round(rand(1, 5), 2) : ($discountType === 'percent' ? rand(5, 15) : 0);
            $discountAmount = $discountType === 'flat'
                ? min($discountValue, $subtotal)
                : ($discountType === 'percent' ? $subtotal * ($discountValue / 100) : 0);

            $useCustomer = rand(1, 100) <= 40;
            $customerId = null;
            $customerName = null;
            $customerPhone = null;

            if ($useCustomer) {
                $picked = $fakeCustomers[array_rand($fakeCustomers)];
                $customer = Customer::firstOrCreate(
                    ['phone' => $picked['phone']],
                    ['name' => $picked['name']]
                );
                $customerId = $customer->id;
                $customerName = $picked['name'];
                $customerPhone = $picked['phone'];
            }

            $sale = Sale::create([
                'user_id' => $staffPool[array_rand($staffPool)]->id,
                'customer_id' => $customerId,
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'subtotal' => $subtotal,
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'total_amount' => $subtotal - $discountAmount,
                'created_at' => $saleDate,
                'updated_at' => $saleDate,
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
                    'user_id' => $sale->user_id,
                    'type' => 'out',
                    'quantity' => $line['quantity'],
                    'reason' => 'Sale #' . $sale->id,
                    'date' => $saleDate->toDateString(),
                    'created_at' => $saleDate,
                    'updated_at' => $saleDate,
                ]);
            }
        }

        // --- Expenses ---
        $expenseDefs = [
            ['Rent', 800.00, null],
            ['Utilities', 120.50, null],
            ['Utilities', 95.00, null],
            ['Supplies', 45.20, null],
            ['Supplies', 62.10, null],
            ['Marketing', 150.00, null],
            ['Wages', 900.00, null],
            ['Wages', 900.00, null],
            ['Other', 35.00, 'Window cleaning'],
            ['Other', 18.50, 'Parking permit renewal'],
            ['Rent', 800.00, null],
            ['Supplies', 28.75, null],
            ['Marketing', 60.00, null],
            ['Utilities', 88.30, null],
            ['Other', 12.00, 'First aid kit restock'],
        ];

        foreach ($expenseDefs as [$category, $amount, $description]) {
            Expense::create([
                'category' => $category,
                'amount' => $amount,
                'description' => $description,
                'date' => now()->subDays(rand(0, 29))->toDateString(),
                'user_id' => $admin->id,
            ]);
        }

        $this->command->info('Demo data seeded: ' . count($products) . ' products, 40 sales, ' . count($expenseDefs) . ' expenses.');
    }
}