<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    protected $fillable = [
        'type',
        'company',
        'cost',
        'payment_date',
        'status',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'payment_date' => 'date',
    ];
}
