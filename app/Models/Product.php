<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'product_code',
        'name',
        'slug',
        'category_id',
        'brand_id',
        'image',
        'small_description',
        'description',
        'quantity',
        'price',
        'status',
        'rating',
        'is_new',
        'is_trending',
        'height',
        'weight',
        'width',
        'length',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class)->withTrashed();
    }
    public function productCollection()
    {
        return $this->hasMany(ProductCollection::class, 'product_id', 'id');
    }
    public function productImage()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
