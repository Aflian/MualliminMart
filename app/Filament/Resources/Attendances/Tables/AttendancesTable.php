<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('check_in', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Kasir/Admin')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('shift.shift_name')
                    ->label('Shift')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('check_in')
                    ->label('Jam Masuk')
                    ->dateTime(timezone: 'Asia/Jakarta')
                    ->sortable(),

                TextColumn::make('check_out')
                    ->label('Jam Pulang')
                    ->dateTime(timezone: 'Asia/Jakarta')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'masuk',
                        'primary' => 'pulang',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(timezone: 'Asia/Jakarta')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime(timezone: 'Asia/Jakarta')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

                // Tombol absen
                Action::make('absen')
                    ->label(fn ($record) => $record->status === 'masuk' ? 'Check-Out' : 'Check-In')
                    ->button()
                    ->color(fn ($record) => $record->status === 'masuk' ? 'primary' : 'success')
                    ->action(function ($record) {
                        if ($record->status === 'masuk') {
                            $record->update([
                                'check_out' => now(),
                                'status' => 'pulang',
                            ]);
                        } else {
                            $record->update([
                                'check_in' => now(),
                                'status' => 'masuk',
                            ]);
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
