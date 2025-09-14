<?php

namespace App\Filament\Kasir\Resources\Attendances\Tables;

use Carbon\Carbon;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Attendance;



class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(fn()=> Attendance::query()->where('user_id',Auth::id()))
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
                // EditAction::make(),

                // 🔹 Tombol absen (Check-In / Check-Out)
                Action::make('absen')
                    ->label(fn ($record) => $record->status === 'masuk' ? 'Check-Out' : 'Check-In')
                    ->icon(fn ($record) => $record->status === 'masuk' ? 'heroicon-o-user' : 'heroicon-o-user')
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
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
