<?php

namespace App\Filament\Resources\Cashbooks;

use App\Filament\Resources\Cashbooks\Pages\CreateCashbook;
use App\Filament\Resources\Cashbooks\Pages\EditCashbook;
use App\Filament\Resources\Cashbooks\Pages\ListCashbooks;
use App\Filament\Resources\Cashbooks\Schemas\CashbookForm;
use App\Filament\Resources\Cashbooks\Tables\CashbooksTable;
use App\Models\Cashbook;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CashbookResource extends Resource
{
    protected static ?string $model = Cashbook::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CashbookForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CashbooksTable::configure($table);
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
            'index' => ListCashbooks::route('/'),
            'create' => CreateCashbook::route('/create'),
            'edit' => EditCashbook::route('/{record}/edit'),
        ];
    }
}
