<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyReview extends Model
{
    use HasFactory;
    protected $table = 'reply_review';
    protected $fillable = [
        'review_id',
        'reply_customer_id',
        'comment',
        'name',
    ];
}
