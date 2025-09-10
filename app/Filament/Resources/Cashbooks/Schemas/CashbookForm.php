<?php

namespace App\Filament\Resources\Cashbooks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CashbookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('transaction_id')
                    ->numeric(),
                Select::make('type')
                    ->options(['in' => 'In', 'out' => 'Out'])
                    ->required(),
                Select::make('category')
                    ->options(['penjualan' => 'Penjualan', 'pembelian' => 'Pembelian', 'operasional' => 'Operasional'])
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('description'),
                TextInput::make('reference'),
            ]);
    }
}
