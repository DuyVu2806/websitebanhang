<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    use HasFactory;
    protected $table = 'product_collection';
    protected $fillable = [
        'product_id',
        'name_collection',
        'quantity',
        'price'
    ];
}
