<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontraktorProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'foto_profile',
        'nama_depan',
        'nama_belakang',
        'nomor_telepon',
        'email',
        'alamat',
        'nama_perusahaan',
        'nomor_npwp',
        'bidang_usaha',
        'dokumen_pendukung',
        'portofolio',
        'status', // Tambahkan ini
        'catatan_admin', // Tambahkan ini
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(KontraktorFile::class);
    }
}
