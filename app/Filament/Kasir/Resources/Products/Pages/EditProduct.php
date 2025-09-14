<?php

namespace App\Filament\Kasir\Resources\Products\Pages;

use App\Filament\Kasir\Resources\Products\ProductResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
