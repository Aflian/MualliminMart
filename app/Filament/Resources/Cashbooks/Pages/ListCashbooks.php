<?php

namespace App\Filament\Resources\Cashbooks\Pages;

use App\Filament\Resources\Cashbooks\CashbookResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCashbooks extends ListRecords
{
    protected static string $resource = CashbookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
