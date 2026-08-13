<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $fillable = ['product_code', 'name', 'barcode', 'buying_price', 'selling_price', 'status'];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function consumeFifo(int $quantityNeeded): array
    {
        $remaining = $quantityNeeded;
        $consumed = [];

        $batches = $this->stockMovements()
            ->where('type', 'in')
            ->where('remaining_quantity', '>', 0)
            ->orderBy('date')
            ->orderBy('id')
            ->lockForUpdate()
            ->get();

        foreach ($batches as $batch) {
            if ($remaining <= 0) break;

            $take = min($remaining, $batch->remaining_quantity);
            $batch->decrement('remaining_quantity', $take);

            $consumed[] = [
                'stock_movement_id' => $batch->id,
                'quantity' => $take,
                'unit_cost' => $batch->unit_cost,
            ];

            $remaining -= $take;
        }

        if ($remaining > 0) {
            $consumed[] = [
                'stock_movement_id' => null,
                'quantity' => $remaining,
                'unit_cost' => $this->buying_price,
            ];
        }

        return $consumed;
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }
}