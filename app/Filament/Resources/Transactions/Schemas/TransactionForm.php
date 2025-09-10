<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('shift_id')
                    ->numeric(),
                TextInput::make('vendor_id')
                    ->numeric(),
                TextInput::make('customer_name'),
                Select::make('category')
                    ->options(['penjualan' => 'Penjualan', 'pembelian' => 'Pembelian'])
                    ->required(),
                TextInput::make('payment_method_id')
                    ->required()
                    ->numeric(),
                Select::make('payment_status')
                    ->options(['lunas' => 'Lunas', 'hutang' => 'Hutang', 'gagal' => 'Gagal'])
                    ->default('lunas')
                    ->required(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DateTimePicker::make('transaction_date')
                    ->required(),
                DateTimePicker::make('due_date'),
            ]);
    }
}
