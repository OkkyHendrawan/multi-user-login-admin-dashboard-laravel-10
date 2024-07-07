<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    public static function getRecord()
{
    $return = KelasModel::select('kelas.*', 'users.name as created_by_name')
        ->join('users', 'users.id', '=', 'kelas.created_by')
        ->orderBy('kelas.kelas_id', 'desc')
        ->get();

    return $return;
}


    static public function getKelas()
    {
        $return = KelasModel::select('*')
            ->orderBy('kelas_nama', 'asc')
            ->get();

        return $return;
    }
}

