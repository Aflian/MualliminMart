<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Absen Kasir')
                ->description('Form absen masuk dan pulang untuk kasir/admin.')
                ->schema([
                    Select::make('user_id')
                        ->label('Kasir/Admin')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->required(),

                    Select::make('shift_id')
                        ->label('Shift')
                        ->relationship('shift', 'shift_name')
                        ->searchable()
                        ->required(),

                    DateTimePicker::make('check_in')
                        ->label('Jam Masuk')
                        ->placeholder('Otomatis saat absen masuk'),

                    DateTimePicker::make('check_out')
                        ->label('Jam Pulang')
                        ->placeholder('Otomatis saat absen pulang'),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'masuk' => 'Masuk',
                            'pulang' => 'Pulang',
                        ])
                        ->default('masuk')
                        ->required(),
                ]),
        ]);
    }
}
