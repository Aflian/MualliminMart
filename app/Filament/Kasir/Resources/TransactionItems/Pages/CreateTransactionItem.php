<?php

namespace App\Filament\Kasir\Resources\TransactionItems\Pages;

use App\Filament\Kasir\Resources\TransactionItems\TransactionItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransactionItem extends CreateRecord
{
    protected static string $resource = TransactionItemResource::class;
}
