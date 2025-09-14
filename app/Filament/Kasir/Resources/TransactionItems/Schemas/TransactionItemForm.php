<?php

namespace App\Filament\Kasir\Resources\TransactionItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Pilih transaksi (dengan label)
                Select::make('transaction_id')
                    ->label('Transaksi')
                    ->relationship('transaction', 'invoice_number')
                    ->required(),

                // Pilih produk
                Select::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'name')
                    ->required(),

                // Jumlah
                TextInput::make('quantity')
                    ->label('Kuantitas')
                    ->numeric()
                    ->required()
                    ->reactive(), // supaya bisa trigger kalkulasi subtotal

                // Satuan
                Select::make('unit')
                    ->label('Satuan')
                    ->options([
                        'pcs' => 'Pcs',
                        'kg' => 'Kg',
                        'liter' => 'Liter',
                    ])
                    ->default('pcs')
                    ->required(),

                // Harga
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->required()
                    ->prefix('Rp')
                    ->reactive(),

                // Subtotal otomatis dihitung
                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->disabled()
                    ->default(0)
                    ->dehydrated(false) // tidak disimpan langsung, karena dihitung otomatis
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $set('subtotal', $get('quantity') * $get('price'));
                    }),
            ]);
    }
}
