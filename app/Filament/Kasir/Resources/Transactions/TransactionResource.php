<?php

namespace App\Filament\Kasir\Resources\Transactions;

use UnitEnum;
use BackedEnum;
use App\Models\Cashbook;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Kasir\Resources\Transactions\Pages\EditTransaction;
use App\Filament\Kasir\Resources\Transactions\Pages\ListTransactions;
use App\Filament\Kasir\Resources\Transactions\Pages\CreateTransaction;
use App\Filament\Kasir\Resources\Transactions\Schemas\TransactionForm;
use App\Filament\Kasir\Resources\Transactions\Tables\TransactionsTable;

class TransactionResource extends Resource
{
    protected static string | UnitEnum | null $navigationGroup = 'Transaksi';
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationLabel = 'Manajemen Transaksi';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';


    public static function form(Schema $schema): Schema
    {
        return TransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function afterCreate($record): void
    {
        // Jangan masukin ke cashbook kalau hutang
        if ($record->payment_status === 'hutang') {
            return;
        }

        Cashbook::create([
            'transaction_id' => $record->id,
            'type'           => $record->category === 'penjualan' ? 'in' : 'out',
            'category'       => $record->category,
            'amount'         => $record->total_amount,
            'description'    => "Transaksi {$record->category} - {$record->invoice_number}",
            'reference'      => $record->customer_name ?? '-',
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'edit' => EditTransaction::route('/{record}/edit'),
        ];
    }
}
