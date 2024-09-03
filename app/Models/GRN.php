<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GRN extends Model
{
    use HasFactory;
    protected $table = 'grn';

    protected $fillable = [
        'storekeeper',
        'receiving_clerk',
        'supplier',
        'total_price'
    ];
    public function details()
    {
        return $this->hasMany(GRN_detail::class, 'grn_id', 'id');
    }
}
