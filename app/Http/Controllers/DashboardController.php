<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $maleCount = MahasiswaModel::where('mahasiswa_kelamin', 'laki-laki')->where('is_delete', 0)->count();
    $femaleCount = MahasiswaModel::where('mahasiswa_kelamin', 'perempuan')->where('is_delete', 0)->count();
    $totalMahasiswa = $maleCount + $femaleCount;

    return view('admin.dashboard', compact('maleCount', 'femaleCount', 'totalMahasiswa'));
}



    public function dashboard()
    {
        if (Auth::check()) {
            $data['header_tittle'] = 'Dashboard';

            if (Auth::user()->user_type == 1) {
                return view('admin/dashboard', $data);
            } else if (Auth::user()->user_type == 2) {
                return view('dosen/dashboard', $data);
            } else if (Auth::user()->user_type == 3) {
                return view('mahasiswa/dashboard', $data);
            }
        }

        // Redirect ke halaman login jika pengguna tidak terautentikasi
        return redirect()->route('login');
    }
}
