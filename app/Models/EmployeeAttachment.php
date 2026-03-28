<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAttachment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'employee_id',
        'attachment_path',
    ];

    // ─── Relationships ─────────────────────────────────────────
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
