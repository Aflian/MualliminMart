<?php

namespace App\Filament\Kasir\Resources\TransactionItems\Pages;

use App\Filament\Kasir\Resources\TransactionItems\TransactionItemResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTransactionItem extends EditRecord
{
    protected static string $resource = TransactionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
