<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashbook extends Model
{
    protected $fillable = [
        'transaction_id','type','category','amount','description','reference'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
