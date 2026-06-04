<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'table_number',
        'customer_name',
        'notes',
        'status',
        'total',
        'payment_status',
        'payment_method',
        'payment_token',
    ];

    // status: pending | preparing | ready | done
    // payment_status: unpaid | paid | failed

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending'   => 'Menunggu Konfirmasi',
            'preparing' => 'Sedang Diproses',
            'ready'     => 'Siap Diambil',
            'done'      => 'Selesai',
            default     => 'Unknown',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending'   => '#F59E0B',
            'preparing' => '#3B82F6',
            'ready'     => '#10B981',
            'done'      => '#6B7280',
            default     => '#6B7280',
        };
    }

    public function getPaymentStatusLabelAttribute()
    {
        return match ($this->payment_status) {
            'unpaid' => 'Belum Dibayar',
            'paid'   => 'Sudah Dibayar',
            'failed' => 'Pembayaran Gagal',
            default  => 'Unknown',
        };
    }
}
