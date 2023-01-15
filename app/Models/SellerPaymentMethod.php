<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
    ];
}