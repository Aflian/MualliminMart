<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionPrintController extends Controller
{
    public function print($id)
    {
        $transaction = Transaction::with(['items.product', 'paymentMethod', 'user'])->findOrFail($id);

        return view('kasir.transactions.print', compact('transaction'));
    }
}
