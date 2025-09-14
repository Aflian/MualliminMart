<?php

namespace App\Filament\Kasir\Resources\Attendances\Pages;

use App\Filament\Kasir\Resources\Attendances\AttendanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
}
