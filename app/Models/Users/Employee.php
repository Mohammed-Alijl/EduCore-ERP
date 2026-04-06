<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Translatable\HasTranslations;

class Employee extends Authenticatable
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'national_id',
        'password',
        'phone',
        'address',
        'joining_date',
        'gender_id',
        'specialization_id',
        'blood_type_id',
        'nationality_id',
        'religion_id',
        'status',
        'image',
        'designation_id',
        'department_id',
        'contract_type',
        'basic_salary',
        'bank_account_number',
    ];

    /** @var string[] */
    public $translatable = ['name'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'joining_date' => 'date',
        ];
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getImageUrlAttribute(): string
    {
        if (! empty($this->image)) {
            return asset('storage/'.$this->image);
        }

        return asset('assets/admin/img/faces/admin.png');
    }

    protected static function booted(): void
    {
        static::creating(function (Employee $employee) {
            if (empty($employee->employee_code)) {
                $isTeacher = false;
                if ($employee->designation_id) {
                    $designation = Designation::find($employee->designation_id);
                    if ($designation && $designation->can_teach) {
                        $isTeacher = true;
                    }
                }

                $prefix = ($isTeacher ? 'TCH-' : 'EMP-').date('Y').'-';
                $lastEmployee = self::withTrashed()
                    ->where('employee_code', 'like', $prefix.'%')
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastEmployee) {
                    $lastNumber = str_replace($prefix, '', $lastEmployee->employee_code);
                    $nextNumber = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    $nextNumber = '0001';
                }
                $employee->employee_code = $prefix.$nextNumber;
            }
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function bloodType(): BelongsTo
    {
        return $this->belongsTo(TypeBlood::class, 'blood_type_id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(EmployeeAttachment::class, 'employee_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    /**
     * Only active employees.
     *
     * @param  Builder  $query
     */
    public function scopeActive($query): Builder
    {
        return $query->where('status', 1);
    }
}
