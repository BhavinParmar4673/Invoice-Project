<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrederItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item',
        'price',
        'quantity',
        'item_total',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
