<?php

namespace App\Filament\Kasir\Resources\Products;

use App\Filament\Kasir\Resources\Products\Pages\CreateProduct;
use App\Filament\Kasir\Resources\Products\Pages\EditProduct;
use App\Filament\Kasir\Resources\Products\Pages\ListProducts;
use App\Filament\Kasir\Resources\Products\Schemas\ProductForm;
use App\Filament\Kasir\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationLabel = 'Manajemen Produk';

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Barang';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-s-tag';

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
