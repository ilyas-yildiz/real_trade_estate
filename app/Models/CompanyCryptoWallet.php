<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCryptoWallet extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'wallet_type',
        'network',
        'wallet_address',
        'notes',
        'is_active',
    ];
}