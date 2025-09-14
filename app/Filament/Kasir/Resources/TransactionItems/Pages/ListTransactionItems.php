<?php

namespace App\Filament\Kasir\Resources\TransactionItems\Pages;

use App\Filament\Kasir\Resources\TransactionItems\TransactionItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransactionItems extends ListRecords
{
    protected static string $resource = TransactionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
