<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BayiEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'bayi_id',
        'file_path',
        'title',
        'status',
        'admin_note',
        'bayi_note',
        'responded_at'
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    // Hakedişin sahibi (Bayi)
    public function bayi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bayi_id');
    }
}