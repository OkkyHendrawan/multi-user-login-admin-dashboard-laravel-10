<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = KelasModel::getKelas();
        $data['header_tittle'] = "Daftar Kelas";
        return view('admin.kelas.list', compact('kelas'), $data);
    }

    public function form_create()
    {
        $data['header_tittle'] = "Tambah Kelas";
        return view ('admin.kelas.add', $data);
    }

    public function proses_create(Request $request)
    {
        $save = new KelasModel;
        $save->kelas_nama = $request->kelas_nama;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect()->route('admin.kelas.list')->with('success', 'Kelas berhasil ditambahkan');
    }

}
