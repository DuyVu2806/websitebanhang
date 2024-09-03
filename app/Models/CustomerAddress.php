<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $table ='customer_address';
    protected $fillable =[
        'customer_id',
        'fullname',
        'phone',
        'province',
        'province_code',
        'district',
        'district_code',
        'wards',
        'wards_code',
        'address',
        'selected',
    ];
}
