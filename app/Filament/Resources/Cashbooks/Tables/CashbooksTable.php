<?php

namespace App\Filament\Resources\Cashbooks\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Forms;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cashbook;

class CashbooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('transaction.invoice_number')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('items_detail')
                    ->label('Detail Barang')
                    ->getStateUsing(fn ($record) => self::formatTransactionItems($record))
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('type')
                    ->label('Tipe Kas')
                    ->badge()
                    ->colors([
                        'success' => 'in',
                        'danger'  => 'out',
                    ])
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->colors([
                        'success' => 'penjualan',
                        'warning' => 'pembelian',
                        'primary' => 'operasional',
                    ])
                    ->sortable(),

                TextColumn::make('transaction.total_amount')
                    ->label('Jumlah (Rp)')
                    ->money('idr', true)
                    ->sortable()
                    ->alignRight(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('reference')
                    ->label('Referensi')
                    ->wrap()
                    ->toggleable(),

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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                // 🔹 Tombol Download Laporan
                Action::make('downloadReport')
                    ->label('Download Laporan')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('success')
                    ->size('sm') // tombol kecil rapi
                    ->modalHeading('Pilih Periode Laporan')
                    ->modalButton('Download')
                    ->form([
                        Forms\Components\Radio::make('periode')
                            ->label('Periode')
                            ->options([
                                'day'   => 'Per Hari',
                                'week'  => 'Per Minggu',
                                'month' => 'Per Bulan',
                                'all'   => 'Semua Waktu',
                            ])
                            ->default('day')
                            ->inline(), // biar rapih horizontal
                    ])
                    ->action(function (array $data) {
                        return self::exportPdf($data['periode']);
                    }),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function exportPdf(string $type)
    {
        $query = Cashbook::query();

        if ($type === 'day') {
            $query->whereDate('created_at', now());
        } elseif ($type === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($type === 'month') {
            $query->whereMonth('created_at', now()->month);
        }

        $records = $query->get();

        $pdf = Pdf::loadView('exports.cashbook', [
            'records' => $records,
            'periode' => $type,
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "laporan-cashbook-{$type}.pdf"
        );
    }

    protected static function formatTransactionItems($record): string
    {
        if (! $record->transaction) {
            return '-';
        }

        $items = $record->transaction->items ?? collect();

        if ($items->isEmpty()) {
            return '-';
        }

        return $items->map(function ($item) {
            $productName = $item->product->name ?? '—';
            $qty = $item->quantity ?? 0;
            $unit = $item->unit ?? '';
            return "{$productName} ({$qty} {$unit})";
        })->implode(', ');
    }
}
