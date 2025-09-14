<?php

namespace App\Filament\Kasir\Resources\Attendances;

use App\Filament\Kasir\Resources\Attendances\Pages\CreateAttendance;
use App\Filament\Kasir\Resources\Attendances\Pages\EditAttendance;
use App\Filament\Kasir\Resources\Attendances\Pages\ListAttendances;
use App\Filament\Kasir\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Kasir\Resources\Attendances\Tables\AttendancesTable;
use App\Models\Attendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
    protected static ?string $navigationLabel = 'ABSENSI';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-s-check-circle';


    public static function form(Schema $schema): Schema
    {
        return AttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttendancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendances::route('/'),
            'create' => CreateAttendance::route('/create'),
            'edit' => EditAttendance::route('/{record}/edit'),
        ];
    }
}
