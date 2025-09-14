<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','shift_id','check_in','check_out','status'
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    // Accessor untuk check_in dengan timezone Indonesia
    protected function checkIn(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->timezone('Asia/Jakarta') : null,
            set: fn ($value) => $value ? \Carbon\Carbon::parse($value)->timezone('Asia/Jakarta') : null,
        );
    }

    // Accessor untuk check_out dengan timezone Indonesia
    protected function checkOut(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->timezone('Asia/Jakarta') : null,
            set: fn ($value) => $value ? \Carbon\Carbon::parse($value)->timezone('Asia/Jakarta') : null,
        );
    }

    // Method untuk absen masuk
    public function absenMasuk()
    {
        $this->update([
            'check_in' => now()->setTimezone('Asia/Jakarta'),
            'status' => 'masuk'
        ]);
    }

    // Method untuk absen pulang
    public function absenPulang()
    {
        $this->update([
            'check_out' => now()->setTimezone('Asia/Jakarta'),
            'status' => 'pulang'
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
