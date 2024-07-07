<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DosenModel extends Model

{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dosen'; // Nama tabel dalam database
    protected $primaryKey = 'dosen_id'; //id dosen

    // memanggil isi dosen dari tabel dosen
    protected $fillable = [
        'dosen_npp',
        'dosen_nama',
        'email',
        'password',
        'dosen_status',
        'dosen_alamat',
        'dosen_nomor_hp',
        'dosen_foto',
        'dosen_prodi_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke model ProdiModel
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'dosen_prodi_id', 'prodi_id');
    }

    static public function softDeleteDosen($dosen_id)
    {
    // Temukan data fakultas berdasarkan ID
    $dosen = self::find($dosen_id);

    if ($dosen) {
        // Set is_delete menjadi 1 (deleted)
        $dosen->is_delete = 1;
        $dosen->save();
    }

    return $dosen;
    }

    public static function getDosen()
    {
        return self::select('dosen.*', 'prodi.prodi_nama')
            ->join('prodi', 'dosen.dosen_prodi_id', '=', 'prodi.prodi_id')
            ->where('dosen.is_delete', 0)
            ->where('dosen.user_type', 2) // Filter berdasarkan user_type di tabel dosen
            ->orderBy('dosen.dosen_id', 'desc')
            ->paginate(10);
    }

    public static function daftarDosen()
        {
            return self::where('is_delete', 0)->orderBy('dosen_nama', 'asc')->get();
        }


    public static function getDosenSorted($sort)
        {
            // Query data dosen dari database dengan menggunakan Eloquent
            return DosenModel::orderBy('created_at', $sort)->get();
        }

    static public function getTokenSingle($remember_token)
        {
            return DosenModel::where('remember_token', '=', $remember_token)->first();
        }

}

