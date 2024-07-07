<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DosenModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    //Function untuk menampilkan list Dosen
    public function index(Request $request)
    {
        $prodi = ProdiModel::all();
        $dosen = DosenModel::getDosen();
        $data['header_tittle'] = "Daftar Dosen";
        return view('admin.dosen.list', compact('data', 'prodi', 'dosen'), $data);
    }

    //Function untuk menampilkan Form Tambah Dosen
    public function form_create()
    {
        $data['daftarProdi'] = ProdiModel::daftarProdi();
        $data['header_tittle']= "Tambah Dosen";
        return view('admin.dosen.add', $data);
    }

    //Function untuk Menyimpan Data Dosen Baru
    public function proses_create(Request $request)
    {
        // Validasi input
        $request->validate([
            'dosen_npp' => 'required|unique:dosen,dosen_npp',
            'dosen_nama' => 'required',
            'email' => 'required|email|unique:dosen,email',
            'dosen_prodi_id' => 'required',
            'dosen_status' => 'required',
    ]);

    // Memeriksa keunikan nilai dosen_npp sebelum menyisipkan data baru
    $existingNPP = DosenModel::where('dosen_npp', $request->dosen_npp)->first();
        if ($existingNPP) {
            return redirect()->back()->withInput()->withErrors(['dosen_npp' => 'NPP sudah ada dalam database.']);
    }

    // Memeriksa keunikan nilai email sebelum menyisipkan data baru
    $existingEmail = DosenModel::where('email', $request->email)->first();
        if ($existingEmail) {
            return redirect()->back()->withInput()->withErrors(['email' => 'Email sudah ada dalam database.']);
    }
    // Buat instance baru dari model Dosen
    $dosen = new DosenModel;

    // Isi data dari request ke dalam instance Dosen
        $dosen->dosen_npp = trim($request->dosen_npp);
        $dosen->dosen_nama = trim($request->dosen_nama);
        $dosen->email = trim($request->email);
        $dosen->password = Hash::make($request->password); // Enkripsi password
        $dosen->dosen_alamat = trim($request->dosen_alamat);
        $dosen->dosen_nomor_hp = trim($request->dosen_nomor_hp);
        $dosen->dosen_prodi_id = $request->dosen_prodi_id;
        $dosen->is_delete = 0;
        $dosen->user_type = 2;
        $dosen->created_by = Auth::user()->name;

    // Simpan file foto ke folder public/dosen
    if ($request->hasFile('dosen_foto')) {
        $photo = $request->file('dosen_foto');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('dosen'), $photoName); // Pindahkan file ke folder public/dosen
        $dosen->dosen_foto = $photoName; // Simpan nama file foto ke database
    }

        // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
        $currentDateTime = now('Asia/Jakarta');
        $dosen->created_at = $currentDateTime;
        $dosen->updated_at = $currentDateTime;

        // Simpan data dosen ke dalam database
        $dosen->save();

    // Redirect ke halaman list dosen dengan pesan sukses
    return redirect()->route('admin.dosen.list')->with('success', 'Dosen Berhasil di Tambahkan di Daftar Dosen');
    }

    //Function untuk menampilkan Form Edit Dosen
    public function edit($prodi_id)
        {
            $dosen = DosenModel::findOrFail($prodi_id);
            $data['daftarProdi'] = ProdiModel::daftarProdi();
            $data['header_tittle']= "Edit Data Dosen";
            return view('admin.dosen.edit', compact('dosen'), $data);
        }

        //Function untuk memperbarui Data Dosen
    public function update(Request $request, $dosen_id)
        {
            // Temukan dosen berdasarkan ID Dosen
            $dosen = DosenModel::findOrFail($dosen_id);

            // Validasi input
            $request->validate([
                'email' => 'required',
                'dosen_foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // tambahkan validasi untuk foto
            ]);

            // Perbarui nama, NPP, alamat, nomor HP, prodi, dan status dosen
            $dosen->dosen_nama = trim($request->dosen_nama);
            $dosen->dosen_npp = trim($request->dosen_npp);
            $dosen->dosen_alamat = trim($request->dosen_alamat);
            $dosen->dosen_nomor_hp = trim($request->dosen_nomor_hp);
            $dosen->dosen_prodi_id = $request->dosen_prodi_id;
            $dosen->dosen_status = $request->dosen_status;
            $dosen->updated_by = Auth::user()->name;

            // Perbarui email dan password
            $dosen->email = trim($request->email);
            if (!empty($request->password)) {
                $dosen->password = Hash::make($request->password);
            }

            // Perbarui foto jika diunggah
        if ($request->hasFile('dosen_foto')) {
            // Hapus foto lama jika ada
            if ($dosen->dosen_foto && File::exists(public_path('dosen/' . $dosen->dosen_foto))) {
                File::delete(public_path('dosen/' . $dosen->dosen_foto));
            }

            // Simpan foto yang diunggah
            $photo = $request->file('dosen_foto');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('dosen'), $photoName);
            $dosen->dosen_foto = $photoName;
        }

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $dosen->created_at = $currentDateTime;
            $dosen->updated_at = $currentDateTime;

            // Simpan perubahan pada dosen
            $dosen->save();

            // Redirect ke halaman admin list dengan pesan sukses
            return redirect()->route('admin.dosen.list')->with('success', 'Dosen Berhasil di Perbarui di Daftar Dosen');
        }

        //Function untuk mencari Data Dosen berdasarkan nama, email dan prodi
        public function search(Request $request)
        {
            $prodi = ProdiModel::all(); // Ambil semua data prodi untuk ditampilkan di form

            $query = DosenModel::query();
            $data['header_tittle'] = "Daftar Dosen";

            // Filter berdasarkan nama dosen
            if ($request->has('dosen_nama')) {
                $query->where('dosen_nama', 'like', '%' . $request->dosen_nama . '%');
            }

            // Filter berdasarkan email
            if ($request->has('email')) {
                $query->where('email', 'like', '%' . $request->email . '%');
            }

            // Filter berdasarkan prodi
            if ($request->filled('prodi_id')) {
                $query->where('dosen_prodi_id', $request->input('prodi_id'));
            }

            // Ambil data dosen yang telah difilter dan gunakan paginasi
            $dosen = $query->paginate(10); // Menggunakan paginate dengan jumlah per halaman 100

            // Kembalikan view bersama dengan data dosen yang sudah difilter dan semua data prodi
            return view('admin.dosen.list', compact('dosen', 'prodi'), $data);
        }

        //Function untuk menghapus dosen di list tapi tidak di database
        public function softDeleteDosen($dosen_id)
        {
            // Panggil metode softDeleteFakultas dari model FakultasModel
            $dosen = DosenModel::softDeleteDosen($dosen_id);
            if ($dosen) {
                // Jika fakultas berhasil dihapus secara lembut, lakukan tindakan sesuai kebutuhan
                return redirect()->back()->with('success', 'Dosen berhasil dihapus dari Daftar Dosen.');
            } else {
                // Jika fakultas tidak ditemukan, tampilkan pesan kesalahan
                return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
            }
        }

}
