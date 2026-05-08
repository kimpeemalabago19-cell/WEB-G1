<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public const ALLOWED_CATEGORIES = [
        'Clothing',
        'Bags',
        'Gadgets',
        'Documents',
        'Accessories',
        'Others'
    ];

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
        'claim_details',
        'claim_contact',
        'reporter_name',
    ];

    protected function casts(): array
    {
        return [
            'claim_date' => 'datetime',
            'date_found' => 'date',
        ];
    }

    protected function setCategoryAttribute($value)
    {
        $value = trim((string) $value);
        $this->attributes['category'] = in_array($value, self::ALLOWED_CATEGORIES) ? $value : 'Others';
    }

    protected function setItemNameAttribute($value)
    {
        $value = trim((string) $value);
        $badWords = ['fuck', 'shit', 'bitch', 'damn', 'ass', 'fucker', 'pussy', 'cock', 'dick'];
        foreach ($badWords as $word) {
            $value = str_ireplace($word, str_repeat('*', strlen($word)), $value);
        }
        $this->attributes['item_name'] = $value;
    }

    public function getCleanItemNameAttribute()
    {
        return $this->item_name;
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

