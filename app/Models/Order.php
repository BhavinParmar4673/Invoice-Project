<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recevier_name',
        'gradtotal'
    ];

    public function order_item()
    {
        return $this->hasMany(OrederItem::class,'order_id');
    }
}
