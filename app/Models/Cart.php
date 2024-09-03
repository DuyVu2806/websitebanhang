<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table ='carts';
    protected $fillable =[
        'customer_id',
        'product_id',
        'product_collection_id',
        'quantity',
        'checkItem',
    ];

    function product(){
        return $this->belongsTo(Product::class);
    }

    function productCollection(){
        return $this->belongsTo(ProductCollection::class,'product_collection_id','id');
    }
}
