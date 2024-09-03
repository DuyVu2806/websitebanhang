<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table ='order';
    protected $fillable =[
        'customer_id',
        'fullname',
        'email',
        'phone',
        'province',
        'province_code',
        'district',
        'district_code',
        'wards',
        'wards_code',
        'address',
        'status_message',
        'payment_mode',
        'payment_id',
        'total_price'
    ];
    function customer(){
        return $this->belongsTo(Customer::class);
    }
    function orderItem(){
        return $this->hasMany(OrderDetai::class,'order_id','id');
    }
}
