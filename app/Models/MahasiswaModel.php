<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MahasiswaModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'mahasiswa'; // Nama tabel dalam database
    protected $primaryKey = 'mahasiswa_id';

    // Kolom yang bisa di isi dan sesuai tabel database mahasiswa
    protected $fillable = [
        'mahasiswa_nbi',
        'mahasiswa_nama',
        'email',
        'password',
        'mahasiswa_status',
        'mahasiswa_alamat',
        'mahasiswa_nomor_hp',
        'mahasiswa_kelamin',
        'mahasiswa_dosen_id',
        'mahasiswa_kelas_id',
        'mahasiswa_prodi_id',
        'mahasiswa_fakultas_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke model ProdiModel untuk mencari Mahasiswa berdasarkan Prodi
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'mahasiswa_prodi_id', 'prodi_id');
    }

    // Relasi ke model ProdiModel untuk mencari Mahasiswa berdasarkan Prodi
    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'mahasiswa_dosen_id', 'dosen_id');
    }

    // Relasi ke model ProdiModel untuk mencari Mahasiswa berdasarkan Prodi
    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'mahasiswa_kelas_id', 'kelas_id');
    }

    // Relasi ke model ProdiModel untuk mencari Mahasiswa berdasarkan Prodi
    public function fakultas()
    {
        return $this->belongsTo(FakultasModel::class, 'mahasiswa_fakultas_id', 'fakultas_id');
    }

    static public function getMahasiswa()
{
    return self::select(
        'mahasiswa.*',
        'fakultas.fakultas_nama',
        'prodi.prodi_nama',
        'dosen.dosen_nama',
        'kelas.kelas_nama'
    )
    ->join('fakultas', 'mahasiswa.mahasiswa_fakultas_id', '=', 'fakultas.fakultas_id')
    ->join('prodi', 'mahasiswa.mahasiswa_prodi_id', '=', 'prodi.prodi_id')
    ->join('dosen', 'mahasiswa.mahasiswa_dosen_id', '=', 'dosen.dosen_id')
    ->join('kelas', 'mahasiswa.mahasiswa_kelas_id', '=', 'kelas.kelas_id')
    ->where('mahasiswa.is_delete', 0)
    ->where('mahasiswa.user_type', '=', 3)
    ->orderBy('mahasiswa.mahasiswa_id', 'desc')
    ->paginate(10);
}



static public function softDeleteMahasiswa($mahasiswa_id)
    {
    // Temukan data fakultas berdasarkan ID
    $mahasiswa = self::find($mahasiswa_id);

    if ($mahasiswa) {
        // Set is_delete menjadi 1 (deleted)
        $mahasiswa->is_delete = 1;
        $mahasiswa->save();
    }

    return $mahasiswa;

    }

    static public function getTokenSingle($remember_token)
        {
            return MahasiswaModel::where('remember_token', '=', $remember_token)->first();
        }
}

