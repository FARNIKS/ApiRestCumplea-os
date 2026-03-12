<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Assignment extends Model
{
    protected $table = 'Core.assignments';

    protected $fillable = ['position_id', 'department_id'];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'positions_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }
}
