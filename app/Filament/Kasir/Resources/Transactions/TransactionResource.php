<?php

namespace App\Filament\Kasir\Resources\Transactions;

use App\Filament\Kasir\Resources\Transactions\Pages\CreateTransaction;
use App\Filament\Kasir\Resources\Transactions\Pages\EditTransaction;
use App\Filament\Kasir\Resources\Transactions\Pages\ListTransactions;
use App\Filament\Kasir\Resources\Transactions\Schemas\TransactionForm;
use App\Filament\Kasir\Resources\Transactions\Tables\TransactionsTable;
use App\Models\Transaction;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

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

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'edit' => EditTransaction::route('/{record}/edit'),
        ];
    }
}
