<?php

namespace App\Filament\Kasir\Resources\Attendances\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Absen Kasir')
                ->description('Form absen masuk dan pulang untuk kasir')
                ->schema([
                    // User ID otomatis berdasarkan user yang login
                    Hidden::make('user_id')
                        ->default(Auth::id()),

                    // Tampilkan nama kasir yang sedang login
                    TextInput::make('kasir_name')
                        ->label('Nama Kasir')
                        ->default(Auth::user()->name)
                        ->disabled()
                        ->dehydrated(false),

                    // Shift otomatis berdasarkan jadwal kasir
                    Select::make('shift_id')
                        ->label('Shift')
                        ->disabled()
                        ->relationship('shift', 'shift_name')
                        ->default(function () {
                            // Logika untuk menentukan shift aktif berdasarkan waktu
                            $currentHour = now()->hour;

                            if ($currentHour >= 6 && $currentHour < 14) {
                                return 1; // Shift Pagi
                            } elseif ($currentHour >= 14 && $currentHour < 22) {
                                return 2; // Shift Sore
                            } else {
                                return 3; // Shift Malam
                            }
                        })
                        ->required(),

                    // Waktu masuk otomatis
                    DateTimePicker::make('check_in')
                        ->label('Jam Masuk')
                        ->default(now())
                        ->disabled()
                        ->displayFormat('H:i:s')
                        ->seconds(true)
                        ->required(),

                    // Waktu pulang
                    DateTimePicker::make('check_out')
                        ->label('Jam Pulang')
                        ->displayFormat('H:i:s')
                        ->seconds(true)
                        ->disabled()
                        ->nullable(),

                    // Status otomatis
                    Hidden::make('status')
                        ->default('masuk')
                        ->dehydrated(function ($state, $get) {
                            return $get('check_out') ? 'pulang' : 'masuk';
                        }),

                ]),
            ]);
    }
}
