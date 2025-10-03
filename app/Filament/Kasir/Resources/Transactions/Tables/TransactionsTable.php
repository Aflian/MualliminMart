<?php

namespace App\Filament\Kasir\Resources\Transactions\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                ->label('Invoice')
                ->searchable()
                ->sortable()
                ->copyable(),

            TextColumn::make('customer_name')
                ->label('Customer')
                ->searchable()
                ->placeholder('-'),

            TextColumn::make('paymentMethod.name')
                ->label('Metode Pembayaran')
                ->sortable()
                ->badge(),

            TextColumn::make('payment_status')
                ->label('Status Pembayaran')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'lunas' => 'success',
                    'hutang' => 'warning',
                    'gagal' => 'danger',
                    default => 'gray',
                }),

                TextColumn::make('category')
                ->label('Kategori')
                ->badge()
                ->colors([
                    'success' => 'penjualan',
                    'primary' => 'pembelian',
                ])
                ->sortable(),

            TextColumn::make('total_amount')
                ->label('Total')
                ->money('IDR')
                ->sortable(),

            TextColumn::make('transaction_date')
                ->label('Tanggal')
                ->dateTime('d M Y H:i')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record) => route('transactions.print', $record->id))
                    ->openUrlInNewTab(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
