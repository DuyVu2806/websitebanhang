<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GRN_detail extends Model
{
    use HasFactory;
    protected $table = 'grn_detail';
    protected $fillable = [
        'grn_id',
        'product_code',
        'quantity',
        'price',
        'original_price',
        'transportation',
    ];

    public static function calculateAverageOriginalPriceForMonth()
    {
        return self::select('product_code')
            ->selectRaw('AVG(original_price) as average_original_price')
            ->groupBy('product_code')
            ->get();
    }


    public static function calculateAverageOriginalPrice()
    {
        return self::select('product_code')
            ->selectRaw('AVG(original_price) as average_original_price')
            ->groupBy('product_code')
            ->get();
    }
}
