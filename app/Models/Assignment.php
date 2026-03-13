<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Assignment extends Model
{
    protected $table = 'assignments';

    // Añade esta línea:
    public $timestamps = false;

    protected $fillable = ['positions_id', 'departments_id'];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'positions_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }
}
