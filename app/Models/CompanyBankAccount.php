<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBankAccount extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'bank_name',
        'account_holder_name',
        'iban',
        'account_number',
        'branch_name',
        'is_active',
    ];
}