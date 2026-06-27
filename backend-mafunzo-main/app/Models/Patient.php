<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'blood_type',
        'allergies',
        'medical_history',
        'emergency_contact',
        'registered_date',
        'course_id',
        // Medical Examination Fields
        'blood_pressure',
        'malaria_test',
        'sugar_test',
        'hepatitis_test',
        'pregnancy_test',
        'weight',
        'height',
        'hb_hemoglobin',
        'hiv_status',
        // Medical History Fields
        'chronic_illnesses',
        'trauma_history',
    ];

    protected function casts(): array
    {
        return [
            'registered_date' => 'date',
        ];
    }

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function medicalReports()
    {
        return $this->hasMany(MedicalReport::class);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
