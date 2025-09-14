<?php

namespace App\Filament\Kasir\Resources\Transactions\Pages;

use App\Filament\Kasir\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
