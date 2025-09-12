<?php

namespace App\Filament\Resources\Cashbooks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Transaction;

class CashbookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('transaction_id')
                    ->label('Transaksi Terkait (Opsional)')
                    ->options(function () {
                        return Transaction::all()->pluck('invoice_number', 'id')->toArray();
                    })
                    ->searchable()
                    ->nullable(),

                Select::make('type')
                    ->label('Tipe Kas')
                    ->options([
                        'in' => 'Masuk',
                        'out' => 'Keluar',
                    ])
                    ->required(),

                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'penjualan' => 'Penjualan',
                        'pembelian' => 'Pembelian',
                        'operasional' => 'Operasional',
                    ])
                    ->required(),

                TextInput::make('amount')
                    ->label('Jumlah (Rp)')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->nullable(),

                TextInput::make('reference')
                    ->label('Referensi')
                    ->nullable(),
            ]);
    }
}
