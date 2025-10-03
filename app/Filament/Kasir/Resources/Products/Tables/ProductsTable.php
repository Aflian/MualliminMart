<?php

namespace App\Filament\Kasir\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->size(40),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vendor.name')
                    ->label('Supplier')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('unit')
                    ->label('Satuan')
                    ->badge()
                    ->sortable(),

                TextColumn::make('purchase_price')
                    ->label('Harga Beli')
                    ->money('idr')
                    ->sortable(),

                TextColumn::make('selling_price')
                    ->label('Harga Jual')
                    ->money('idr')
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->badge()
                    ->colors([
                        'danger'  => fn ($state) => $state < 20,           // merah
                        'warning' => fn ($state) => $state >= 20 && $state < 50, // kuning
                        'success' => fn ($state) => $state >= 50,          // hijau
                    ])
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'available',
                        'warning' => 'return',
                        'danger'  => 'expired',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(timezone: 'Asia/Jakarta')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime(timezone: 'Asia/Jakarta')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Bisa ditambahkan filter khusus stok atau status
            ])
            ->recordActions([
                // EditAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
