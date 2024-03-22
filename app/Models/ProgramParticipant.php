<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramParticipant extends Model
{
    use HasFactory;

    protected $table = 'program_participants';

    protected $fillable = [
        'program_id',
        'entity_id',
        'entity_type',
    ];

    public function entity()
    {
        return $this->morphTo();
    }
}
