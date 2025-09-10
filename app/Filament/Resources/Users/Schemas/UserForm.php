<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                Select::make('roles')
                    ->options(['admin' => 'Admin', 'kasir' => 'Kasir'])
                    ->default('kasir')
                    ->required(),
                Select::make('status')
                    ->options(['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'])
                    ->default('nonaktif')
                    ->required(),
                TextInput::make('username'),
                TextInput::make('foto'),
                TextInput::make('alamat'),
                TextInput::make('no_hp'),
                Select::make('gender')
                    ->options(['Laki-laki' => 'Laki laki', 'Perempuan' => 'Perempuan']),
                TextInput::make('tempat_lahir'),
                DatePicker::make('tanggal_lahir'),
                TextInput::make('nik'),
                TextInput::make('nama_ibu'),
                TextInput::make('nama_ayah'),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
