<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetai extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $fillable = [
        'order_id',
        'product_id',
        'product_collection_id',
        'quantity',
        'price',
        'rstatus',
    ];


    function order()
    {
        return $this->hasMany(Order::class, 'id', 'order_id');
    }
    function product()
    {
        return $this->belongsTo(Product::class);
    }
    function productCollection()
    {
        return $this->belongsTo(ProductCollection::class);
    }
    public static function getOriginalPriceByProductCode()
    {
        return self::select('products.product_code', 'order_detail.price', 'order_detail.quantity')
            ->join('products', 'order_detail.product_id', '=', 'products.id')
            ->join('order', 'order_detail.order_id', '=', 'order.id')
            ->where('order.status_message', '=', 3)
            ->groupBy('products.product_code', 'order_detail.price', 'order_detail.quantity')
            ->get();
    }
    public static function getOriginalPriceByProductCodeForMonth($month, $year)
    {
        return self::select('products.product_code', 'order_detail.price', 'order_detail.quantity')
            ->whereYear('order_detail.created_at', $year)
            ->whereMonth('order_detail.created_at', $month)
            ->join('products', 'order_detail.product_id', '=', 'products.id')
            ->join('order', 'order_detail.order_id', '=', 'order.id')
            ->where('order.status_message', '=', 3)
            ->groupBy('products.product_code', 'order_detail.price', 'order_detail.quantity')
            ->get();
    }
}
