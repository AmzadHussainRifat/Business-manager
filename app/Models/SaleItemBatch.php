<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['sale_item_id', 'stock_movement_id', 'quantity', 'unit_cost'])]
class SaleItemBatch extends Model
{
    public function stockMovement()
    {
        return $this->belongsTo(StockMovement::class);
    }
}