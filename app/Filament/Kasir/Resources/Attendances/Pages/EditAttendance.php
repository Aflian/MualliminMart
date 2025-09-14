<?php

namespace App\Filament\Kasir\Resources\Attendances\Pages;

use App\Filament\Kasir\Resources\Attendances\AttendanceResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAttendance extends EditRecord
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
