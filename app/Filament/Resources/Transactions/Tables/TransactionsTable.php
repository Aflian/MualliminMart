<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('transaction_date', 'desc')
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Kasir/Admin')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('shift.shift_name')
                    ->label('Shift')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('vendor.name')
                    ->label('Vendor/Supplier')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('customer_name')
                    ->label('Nama Customer')
                    ->searchable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->colors([
                        'success' => 'penjualan',
                        'primary' => 'pembelian',
                    ])
                    ->sortable(),

                TextColumn::make('payment_method.name')
                    ->label('Metode Pembayaran')
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->colors([
                        'success' => 'lunas',
                        'warning' => 'hutang',
                        'danger'  => 'gagal',
                    ])
                    ->sortable(),

                // 🔹 Tambahan Subtotal dari relasi items
                TextColumn::make('items_sum_subtotal')
                    ->label('Subtotal (Rp)')
                    ->money('idr', true)
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->items->sum(fn ($item) => $item->quantity * $item->price)),

                TextColumn::make('total_amount')
                    ->label('Total (Rp)')
                    ->money('idr', true)
                    ->sortable(),

                TextColumn::make('transaction_date')
                    ->label('Tanggal Transaksi')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
