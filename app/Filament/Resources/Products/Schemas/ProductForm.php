<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Produk')
                ->description('Lengkapi detail produk yang akan disimpan.')
                ->schema([
                    Select::make('vendor_id')
                        ->label('Supplier')
                        ->relationship('vendor', 'name')
                        ->searchable()
                        ->required(),

                    TextInput::make('sku')
                        ->label('SKU')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    TextInput::make('name')
                        ->label('Nama Produk')
                        ->required(),

                    FileUpload::make('foto')
                        ->label('Foto Produk')
                        ->directory('products')
                        ->disk('public')
                        ->visibility('public')
                        ->image()
                        ->imageEditor()
                        ->maxSize(2048),
                ]),

            Section::make('Harga & Stok')
                ->description('Atur harga jual, harga beli, serta stok produk.')
                ->schema([
                    TextInput::make('purchase_price')
                        ->label('Harga Beli')
                        ->numeric()
                        ->minValue(0)
                        ->required(),

                    TextInput::make('selling_price')
                        ->label('Harga Jual')
                        ->numeric()
                        ->minValue(0)
                        ->required(),

                        TextInput::make('stock')
                        ->label('Stok (Otomatis)')
                        ->numeric()
                        ->default(0)
                        ->disabled()
                        ->dehydrated(false)
                        ->suffix('unit')
                        ->helperText('Stok dihitung otomatis dari transaksi.'),

                    Select::make('unit')
                        ->label('Satuan')
                        ->options([
                            'pcs' => 'Pcs',
                            'kg' => 'Kg',
                            'liter' => 'Liter',
                        ])
                        ->default('pcs')
                        ->required(),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'available' => 'Tersedia',
                            'return'    => 'Retur',
                            'expired'   => 'Kadaluarsa',
                        ])
                        ->default('available')
                        ->required(),
                ]),
        ]);
    }
}
