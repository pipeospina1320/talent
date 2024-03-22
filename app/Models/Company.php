<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'image_path',
        'location',
        'industry',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programParticipants()
    {
        return $this->morphMany(ProgramParticipant::class, 'entity');
    }
}
