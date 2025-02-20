<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontraktorFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'kontraktor_profile_id',
        'file_path',
        'file_type',
    ];

    // Relasi ke KontraktorProfile
    public function kontraktorProfile()
    {
        return $this->belongsTo(KontraktorProfile::class);
    }
}
