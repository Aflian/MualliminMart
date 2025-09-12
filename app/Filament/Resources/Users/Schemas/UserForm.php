<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Akun')
                ->description('Data utama pengguna dan akses login.')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required(),

                    TextInput::make('email')
                        ->label('Email address')
                        ->email()
                        ->required(),

                    DateTimePicker::make('email_verified_at')
                        ->label('Email diverifikasi'),

                    Select::make('roles')
                        ->label('Role')
                        ->options([
                            'admin' => 'Admin',
                            'kasir' => 'Kasir',
                        ])
                        ->default('kasir')
                        ->required(),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'aktif' => 'Aktif',
                            'nonaktif' => 'Nonaktif',
                        ])
                        ->default('nonaktif')
                        ->required(),

                    TextInput::make('username')
                        ->label('Username'),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->required(),
                ]),

            Section::make('Data Pribadi')
                ->description('Lengkapi biodata pengguna.')
                ->schema([
                    FileUpload::make('foto')->label('Foto Profil')
                        ->disk('public')
                        ->image()
                        ->imageEditor()
                        ->maxSize(2048)
                        ->visibility('public')
                        ->directory('FotoUser'),

                    TextInput::make('alamat')->label('Alamat'),

                    TextInput::make('no_hp')->label('Nomor HP')
                        ->numeric(),

                    Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->options([
                            'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                        ]),

                    TextInput::make('tempat_lahir')->label('Tempat Lahir'),

                    DatePicker::make('tanggal_lahir')->label('Tanggal Lahir'),

                    TextInput::make('nik')->label('NIK'),

                    TextInput::make('nama_ibu')->label('Nama Ibu'),

                    TextInput::make('nama_ayah')->label('Nama Ayah'),
                ]),
        ]);
    }
}
