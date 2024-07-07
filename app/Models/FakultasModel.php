<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakultasModel extends Model
{
    use HasFactory;

    protected $table = 'fakultas';
    protected $primaryKey = 'fakultas_id'; // Menyesuaikan dengan nama kolom primary key

    protected $fillable = [
        'fakultas_kode', 'fakultas_nama', 'fakultas_status'
    ];

    static public function softDeleteFakultas($fakultas_id)
{
    // Temukan data fakultas berdasarkan ID
    $fakultas = self::find($fakultas_id);

    if ($fakultas) {
        // Set is_delete menjadi 1 (deleted)
        $fakultas->is_delete = 1;
        $fakultas->save();
    }

    return $fakultas;
}


static public function getFakultas()
    {
        return self::select('fakultas.*')
            ->where('fakultas.is_delete', 0)
            ->orderBy('fakultas_nama', 'desc')
            ->paginate(5);
    }

    public static function daftarFakultas()
        {
            return self::where('is_delete', 0)->orderBy('fakultas_nama', 'asc')->get();
        }


}
