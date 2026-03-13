<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Branch extends Model
{
    protected $table = 'branches';

    protected $fillable = ['code', 'country', 'total_staff', 'company_id'];

    // Añade esta línea:
    public $timestamps = false;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => mb_convert_case($value, MB_CASE_TITLE, "UTF-8"),
            set: fn(string $value) => mb_strtoupper($value, "UTF-8"),
        );
    }
    protected function country(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => mb_convert_case($value, MB_CASE_TITLE, "UTF-8"),
            set: fn(string $value) => mb_strtoupper($value, "UTF-8"),
        );
    }
}
