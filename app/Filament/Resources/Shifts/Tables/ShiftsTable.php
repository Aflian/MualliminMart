<?php

namespace App\Filament\Resources\Shifts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Carbon\Carbon;

class ShiftsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('start_time', 'asc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Kasir/Admin')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('shift_name')
                    ->label('Nama Shift')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Mulai')
                    ->time()
                    ->sortable(),

                TextColumn::make('end_time')
                    ->label('Selesai')
                    ->time()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => fn ($state, $record) => self::isActive($record),
                        'secondary' => fn ($state, $record) => !self::isActive($record),
                    ])
                    ->getStateUsing(fn ($record) => self::isActive($record) ? 'Aktif' : 'Nonaktif'),

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

    // Cek apakah shift sedang aktif
    protected static function isActive($record): bool
    {
        $now = Carbon::now()->format('H:i:s');
        return $record->start_time <= $now && $record->end_time >= $now;
    }
}
