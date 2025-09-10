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

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function cashbook()
    {
        return $this->hasOne(Cashbook::class);
    }
}
