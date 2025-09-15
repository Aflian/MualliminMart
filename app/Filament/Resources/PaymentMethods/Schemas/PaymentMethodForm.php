<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class PaymentMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description')
                    ->label('Deskripsi Pembayaran')
                    ->placeholder('No.Rekening - Nama Bank.....'),
                FileUpload::make('foto')
                 ->label('Foto')
                 ->disk('public')
                 ->visibility('public')
                 ->directory('metodePemabayaran')
                 ->maxSize(2048)
                 ->image(),
            ]);
    }
}
