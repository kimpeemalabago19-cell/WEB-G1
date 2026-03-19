<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'description',
        'category',
        'status',
        'image',
        'date_found',
        'reported_by',
        'claimed_by',
        'claim_date',
        'reporter_name',
    ];

    protected function casts(): array
    {
        return [
            'claim_date' => 'datetime',
            'date_found' => 'date',
        ];
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function claimer()
    {
        return $this->belongsTo(User::class, 'claimed_by');
    }
}

