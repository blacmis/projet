<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegisterSession extends Model
{
    protected $fillable = [
        'cashier_email', 'cashier_name', 'opening_amount', 'opened_at',
        'expected_cash', 'expected_mobile_money', 'expected_card',
        'counted_cash', 'counted_mobile_money', 'counted_card',
        'variance', 'closing_notes', 'closed_at', 'status',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'register_session_id');
    }

    public static function openFor(string $email): ?self
    {
        return static::where('cashier_email', $email)
            ->where('status', 'open')
            ->orderByDesc('opened_at')
            ->first();
    }
}