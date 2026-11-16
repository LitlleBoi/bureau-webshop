<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'used',
        'assigned_to',
        'used_by',
        'used_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function usedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function claim(): HasOne
    {
        return $this->hasOne(Claim::class);
    }

    public static function generateCode(int $length = 8): string
    {
        $letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $digits = '23456789';
        $allChars = $letters . $digits;

        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $allChars[random_int(0, strlen($allChars) - 1)];
            }
        } while (!preg_match('/[A-Z]/', $code) || !preg_match('/[0-9]/', $code) || self::where('code', $code)->exists());

        return $code;
    }
}
