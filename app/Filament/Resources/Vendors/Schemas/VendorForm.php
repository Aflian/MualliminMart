<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('NAMA VENDOR')
                    ->required(),
                TextInput::make('contact')
                    ->label('KONTAK VENDOR')
                    ->placeholder('NO-TLP : 08XXXXXXXXX'),
                Textarea::make('address')
                    ->Label('ALAMAN VENDOR')
                    ->columnSpanFull(),
            ]);
    }
}
