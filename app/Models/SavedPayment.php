<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'transaction_date',
        'amount',
        'note',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    protected $attributes = [
        'status' => 'confirmed',
    ];
}
