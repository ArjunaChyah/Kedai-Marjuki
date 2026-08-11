<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'notes',
        'total_price',
        'payment_method',
        'payment_status',
        'order_status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp' . number_format($this->total_price, 0, ',', '.');
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'Belum Dibayar',
            'waiting_confirmation' => 'Menunggu Verifikasi',
            'paid' => 'Sudah Dibayar',
            'rejected' => 'Pembayaran Ditolak',
            'cancelled' => 'Dibatalkan',
            default => $this->payment_status,
        };
    }

    public function getOrderStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'ready' => 'Siap Diambil/Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->order_status,
        };
    }
}
