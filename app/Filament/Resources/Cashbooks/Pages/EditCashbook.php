<?php

namespace App\Filament\Resources\Cashbooks\Pages;

use App\Filament\Resources\Cashbooks\CashbookResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCashbook extends EditRecord
{
    protected static string $resource = CashbookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
