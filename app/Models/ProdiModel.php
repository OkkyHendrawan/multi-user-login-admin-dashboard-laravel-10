<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'prodi_id';

    protected $fillable = [
        'prodi_kode', 'prodi_nama', 'prodi_fakultas_id', 'prodi_status'
    ];

    public function fakultas()
    {
        return $this->belongsTo(FakultasModel::class, 'prodi_fakultas_id', 'fakultas_id');
    }

    static public function softDeleteProdi($prodi_id)
    {
    // Temukan data fakultas berdasarkan ID
    $prodi = self::find($prodi_id);

    if ($prodi) {
        // Set is_delete menjadi 1 (deleted)
        $prodi->is_delete = 1;
        $prodi->save();
    }

    return $prodi;
    }

    public static function getProdi()
        {
            return self::select('prodi.*', 'fakultas.fakultas_nama')
                        ->join('fakultas', 'prodi.prodi_fakultas_id', '=', 'fakultas.fakultas_id')
                        ->where('prodi.is_delete', 0)
                        ->orderBy('prodi.prodi_nama', 'desc')
                        ->paginate(10);
        }

    public static function daftarProdi()
        {
            return self::where('is_delete', 0)->orderBy('prodi_nama', 'asc')->get();
        }


}
