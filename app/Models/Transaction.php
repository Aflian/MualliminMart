<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number','user_id','shift_id','vendor_id',
        'customer_name','category','payment_method_id',
        'payment_status','total_amount','transaction_date','due_date'
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    protected static function booted()
{
    // sebelum simpan (create atau update)
    static::saving(function ($transaction) {
        // hitung ulang total dari item
        $transaction->total_amount = $transaction->items->sum(
            fn ($item) => $item->quantity * $item->price
        );
    });

    // saat transaksi dibuat
    static::created(function ($transaction) {
        $type = $transaction->category === 'penjualan' ? 'in' : 'out';

        $transaction->cashbook()->create([
            'type'        => $type,
            'category'    => $transaction->category,
            'amount'      => $transaction->total_amount, // sekarang sudah terisi
            'description' => 'Auto entry dari transaksi ' . strtoupper($transaction->category) .
                             ' #' . $transaction->invoice_number,
            'reference'   => $transaction->invoice_number,
        ]);
    });

    // saat transaksi diupdate
    static::updated(function ($transaction) {
        $cashbook = $transaction->cashbook;

        if ($cashbook) {
            $cashbook->update([
                'type'        => $transaction->category === 'penjualan' ? 'in' : 'out',
                'category'    => $transaction->category,
                'amount'      => $transaction->total_amount, // ikut update
                'description' => 'Update auto entry dari transaksi ' . strtoupper($transaction->category) .
                                 ' #' . $transaction->invoice_number,
                'reference'   => $transaction->invoice_number,
            ]);
        }
    });

    // saat transaksi dihapus
    static::deleted(function ($transaction) {
        $transaction->cashbook()->delete();
    });
}


    public function getTotalAmountAttribute()
    {
        return $this->items->sum(fn ($item) => $item->quantity * $item->price);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function cashbook()
    {
        return $this->hasOne(Cashbook::class);
    }
}
