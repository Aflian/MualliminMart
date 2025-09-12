<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id','product_id','quantity','unit','price','subtotal'
    ];

    protected static function booted()
    {
        static::created(function ($item) {
            $item->updateProductStock();
        });

        static::updated(function ($item) {
            $item->updateProductStock();
        });

        static::deleted(function ($item) {
            $item->updateProductStock();
        });
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function updateProductStock()
    {
        $product = $this->product;

        if ($product) {
            $stockIn = $product->transactionItems()
                ->whereHas('transaction', fn ($q) => $q->where('category', 'pembelian'))
                ->sum('quantity');

            $stockOut = $product->transactionItems()
                ->whereHas('transaction', fn ($q) => $q->where('category', 'penjualan'))
                ->sum('quantity');

            $product->stock = $stockIn - $stockOut;
            $product->save();
        }
    }
}
