<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('vendor_id')
                    ->numeric(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('foto'),
                Select::make('unit')
                    ->options(['pcs' => 'Pcs', 'kg' => 'Kg', 'liter' => 'Liter'])
                    ->default('pcs')
                    ->required(),
                TextInput::make('purchase_price')
                    ->required()
                    ->numeric(),
                TextInput::make('selling_price')
                    ->required()
                    ->numeric(),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->options(['available' => 'Available', 'return' => 'Return', 'expired' => 'Expired'])
                    ->default('available')
                    ->required(),
            ]);
    }
}
