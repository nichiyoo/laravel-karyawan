<?php

namespace App\Models;

use App\Enums\BloodType;
use App\Enums\Education;
use App\Enums\Gender;
use App\Enums\MaritalStatus;
use App\Enums\Religion;
use App\Enums\TaxStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'last_education' => Education::class,
            'marital_status' => MaritalStatus::class,
            'religion' => Religion::class,
            'blood_type' => BloodType::class,
            'tax_status' => TaxStatus::class,
        ];
    }

    public function families(): HasMany
    {
        return $this->hasMany(EmployeeFamily::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(EmployeeWorkExperience::class);
    }
}
