<?php

namespace App\Filament\Resources\Shifts\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Shift')
            ->columns(1)
                ->description('Atur shift kerja kasir/admin.')
                ->schema([
                    Select::make('user_id')
                        ->label('Kasir/Admin')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->required(),

                    TextInput::make('shift_name')
                        ->label('Nama Shift')
                        ->placeholder('Contoh: Shift Pagi')
                        ->required(),

                    TimePicker::make('start_time')
                        ->label('Waktu Mulai')
                        ->required(),

                    TimePicker::make('end_time')
                        ->label('Waktu Selesai')
                        ->required(),
                ]),
        ]);
    }
}
