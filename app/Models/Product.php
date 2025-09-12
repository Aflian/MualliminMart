<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id','sku','name','foto','unit',
        'purchase_price','selling_price','stock','status'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
    // App\Models\Product.php
    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->transactionItems()->delete();
        });
    }

}
