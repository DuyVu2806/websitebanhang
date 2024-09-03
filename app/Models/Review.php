<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'review';
    protected $fillable = [
        'customer_id',
        'order_item_id',
        'rating',
        'outstanding_feature',
        'collection',
        'comment'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderDetai::class, 'order_item_id', 'id');
    }
}
