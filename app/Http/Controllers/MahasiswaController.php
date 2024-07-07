<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use App\Models\FakultasModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $prodi = ProdiModel::all();
        $kelas = KelasModel::all();
        $fakultas = FakultasModel::all();
        $dosen = DosenModel::all();
        $mahasiswa = MahasiswaModel::getMahasiswa();
        $data['header_tittle'] = "Daftar Mahasiswa";
        return view('admin.mahasiswa.list', compact('data', 'prodi', 'kelas', 'fakultas', 'dosen', 'mahasiswa'), $data);
    }



    public function form_create()
    {
        $data['getKelas'] = KelasModel::getKelas();
        $data['daftarProdi'] = ProdiModel::daftarProdi();
        $data['daftarFakultas'] = FakultasModel::daftarFakultas();
        $data['daftarDosen'] = DosenModel::daftarDosen();
        $data['header_tittle'] = "Tambah Mahasiswa";
        return view('admin.mahasiswa.add', $data);
    }

    public function proses_create(Request $request)
{
    try{
    // Validasi input
    $request->validate([
        'mahasiswa_nbi' => 'required|unique:mahasiswa,mahasiswa_nbi',
        'mahasiswa_nama' => 'required',
        'email' => 'required|email|unique:mahasiswa,email',
        'mahasiswa_prodi_id' => 'required',
        'mahasiswa_fakultas_id' => 'required',
        'mahasiswa_dosen_id' => 'required',
        'mahasiswa_kelas_id' => 'required',
        'mahasiswa_status' => 'required',
        'mahasiswa_tgl_lahir' => 'required|date',
        'mahasiswa_tgl_penerimaan' => 'required|date',
        'mahasiswa_kelamin' => 'required',
        'mahasiswa_ipk' => 'required|numeric',
    ]);

    // Memeriksa keunikan nilai dosen_npp sebelum menyisipkan data baru
    $existingNBI = MahasiswaModel::where('mahasiswa_nbi', $request->mahasiswa_nbi)->first();
    if ($existingNBI) {
        return redirect()->back()->withInput()->withErrors(['mahasiswa_nbi' => 'NBI sudah ada dalam database.']);
    }

    // Memeriksa keunikan nilai email sebelum menyisipkan data baru
    $existingEmail = MahasiswaModel::where('email', $request->email)->first();
    if ($existingEmail) {
        return redirect()->back()->withInput()->withErrors(['email' => 'Email sudah ada dalam database.']);
    }

    // Buat instance baru dari model Mahasiswa
    $mahasiswa = new MahasiswaModel;

    // Isi data dari request ke dalam instance Mahasiswa
    $mahasiswa->mahasiswa_nbi = trim($request->mahasiswa_nbi);
    $mahasiswa->mahasiswa_nama = trim($request->mahasiswa_nama);
    $mahasiswa->email = trim($request->email);
    $mahasiswa->password = Hash::make($request->password); // Enkripsi password
    $mahasiswa->mahasiswa_alamat = trim($request->mahasiswa_alamat);
    $mahasiswa->mahasiswa_nomor_hp = trim($request->mahasiswa_nomor_hp);
    $mahasiswa->mahasiswa_agama = trim($request->mahasiswa_agama);
    $mahasiswa->mahasiswa_prodi_id = $request->mahasiswa_prodi_id;
    $mahasiswa->mahasiswa_dosen_id = $request->mahasiswa_dosen_id;
    $mahasiswa->mahasiswa_fakultas_id = $request->mahasiswa_fakultas_id;
    $mahasiswa->mahasiswa_kelas_id = $request->mahasiswa_kelas_id;
    $mahasiswa->mahasiswa_status = $request->mahasiswa_status;
    $mahasiswa->mahasiswa_tgl_lahir = $request->mahasiswa_tgl_lahir;
    $mahasiswa->mahasiswa_tgl_penerimaan = $request->mahasiswa_tgl_penerimaan;
    $mahasiswa->mahasiswa_kelamin = $request->mahasiswa_kelamin;
    $mahasiswa->mahasiswa_ipk = (float) $request->mahasiswa_ipk;
    $mahasiswa->is_delete = 0;
    $mahasiswa->user_type = 3;
    $mahasiswa->created_by = Auth::user()->name;

    // Pastikan folder public/mahasiswa sudah ada, jika tidak, buat folder tersebut
    if (!File::exists(public_path('mahasiswa'))) {
        File::makeDirectory(public_path('mahasiswa'), 0777, true, true);
    }

    // Simpan file foto ke folder mahasiswa
    if ($request->hasFile('mahasiswa_foto')) {
        $photo = $request->file('mahasiswa_foto');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('mahasiswa'), $photoName); // Pindahkan file ke folder public/mahasiswa
        $mahasiswa->mahasiswa_foto = $photoName; // Simpan nama file foto ke database
    }

        // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
        $currentDateTime = now('Asia/Jakarta');
        $mahasiswa->created_at = $currentDateTime;
        $mahasiswa->updated_at = $currentDateTime;

    // Simpan data mahasiswa ke dalam database
    $mahasiswa->save();

    // Redirect ke halaman list mahasiswa dengan pesan sukses
    return redirect()->route('admin.mahasiswa.list')->with('success', 'Mahasiswa Berhasil di Tambahkan di Daftar Mahasiswa');
} catch (\Exception $e) {
    // Tampilkan pesan error jika terjadi kesalahan
    dd($e->getMessage());
}
}


    public function edit($mahasiswa_id)
        {
            $mahasiswa = MahasiswaModel::findOrFail($mahasiswa_id);
            $data['getKelas'] = KelasModel::getKelas();
            $data['daftarProdi'] = ProdiModel::daftarProdi();
            $data['daftarFakultas'] = FakultasModel::daftarFakultas();
            $data['daftarDosen'] = DosenModel::daftarDosen();
            $data['header_tittle']= "Edit Data Mahasiswa";
            return view('admin.mahasiswa.edit', compact('mahasiswa'), $data);
        }

    public function update(Request $request, $mahasiswa_id)
        {
            // Temukan dosen berdasarkan ID
            $mahasiswa = MahasiswaModel::findOrFail($mahasiswa_id);

            // Validasi input
            $request->validate([
                'email' => 'required',
                'mahasiswa_foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // tambahkan validasi untuk foto
            ]);

            // Perbarui nama, NIB, alamat, nomor HP, prodi, dan status dosen
            $mahasiswa->mahasiswa_nbi = trim($request->mahasiswa_nbi);
            $mahasiswa->mahasiswa_nama = trim($request->mahasiswa_nama);
            $mahasiswa->email = trim($request->email);
            $mahasiswa->password = Hash::make($request->password); // Enkripsi password
            $mahasiswa->mahasiswa_alamat = trim($request->mahasiswa_alamat);
            $mahasiswa->mahasiswa_nomor_hp = trim($request->mahasiswa_nomor_hp);
            $mahasiswa->mahasiswa_agama = trim($request->mahasiswa_agama);
            $mahasiswa->mahasiswa_prodi_id = $request->mahasiswa_prodi_id;
            $mahasiswa->mahasiswa_dosen_id = $request->mahasiswa_dosen_id;
            $mahasiswa->mahasiswa_fakultas_id = $request->mahasiswa_fakultas_id;
            $mahasiswa->mahasiswa_kelas_id = $request->mahasiswa_kelas_id;
            $mahasiswa->mahasiswa_status = $request->mahasiswa_status;
            $mahasiswa->mahasiswa_tgl_lahir = $request->mahasiswa_tgl_lahir;
            $mahasiswa->mahasiswa_tgl_penerimaan = $request->mahasiswa_tgl_penerimaan;
            $mahasiswa->mahasiswa_kelamin = $request->mahasiswa_kelamin;
            $mahasiswa->mahasiswa_ipk = (float) $request->mahasiswa_ipk;
            $mahasiswa->updated_by = Auth::user()->name;

            // Perbarui email dan password
            $mahasiswa->email = trim($request->email);
            if (!empty($request->password)) {
                $mahasiswa->password = Hash::make($request->password);
            }

            // Perbarui foto jika diunggah
        if ($request->hasFile('mahasiswa_foto')) {
            // Hapus foto lama jika ada
            if ($mahasiswa->mahasiswa_foto && File::exists(public_path('mahasiswa/' . $mahasiswa->mahasiswa_foto))) {
                File::delete(public_path('mahasiswa/' . $mahasiswa->mahasiswa_foto));
            }

            // Simpan foto yang diunggah
            $photo = $request->file('mahasiswa_foto');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('mahasiswa'), $photoName);
            $mahasiswa->mahasiswa_foto = $photoName;
        }

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $mahasiswa->created_at = $currentDateTime;
            $mahasiswa->updated_at = $currentDateTime;

            // Simpan perubahan pada dosen
            $mahasiswa->save();

            // Redirect ke halaman admin list dengan pesan sukses
            return redirect()->route('admin.mahasiswa.list')->with('success', 'Mahasiswa Berhasil di Perbarui di Daftar Mahasiswa');
        }

        //Function untuk mencari Data Dosen berdasarkan nama, email dan prodi
        public function search(Request $request)
        {
            $prodi = ProdiModel::all(); // Ambil semua data prodi untuk ditampilkan di form
            $dosen = DosenModel::all(); // Ambil semua data prodi untuk ditampilkan di form
            $kelas = KelasModel::all(); // Ambil semua data prodi untuk ditampilkan di form
            $fakultas = FakultasModel::all(); // Ambil semua data prodi untuk ditampilkan di form
            $query = MahasiswaModel::query();
            $data['header_tittle'] = "Daftar Mahasiswa";

            // Filter berdasarkan nama dosen
            if ($request->has('mahasiswa_nama')) {
                $query->where('mahasiswa_nama', 'like', '%' . $request->mahasiswa_nama . '%');
            }

            // Filter berdasarkan email
            if ($request->has('email')) {
                $query->where('email', 'like', '%' . $request->email . '%');
            }

            // Filter berdasarkan prodi
            if ($request->filled('prodi_id')) {
                $query->where('mahasiswa_prodi_id', $request->input('prodi_id'));
            }

            // Filter berdasarkan prodi
            if ($request->filled('fakultas_id')) {
                $query->where('mahasiswa_fakultas_id', $request->input('fakultas_id'));
            }

            // Ambil data dosen yang telah difilter dan gunakan paginasi
            $mahasiswa = $query->paginate(10); // Menggunakan paginate dengan jumlah per halaman 100

            // Kembalikan view bersama dengan data dosen yang sudah difilter dan semua data prodi
            return view('admin.mahasiswa.list', compact('mahasiswa', 'prodi', 'fakultas'), $data);
        }

    public function softDeleteMahasiswa($mahasiswa_id)
        {
            // Panggil metode softDeleteFakultas dari model FakultasModel
            $mahasiswa = MahasiswaModel::softDeleteMahasiswa($mahasiswa_id);

            if ($mahasiswa) {
                // Jika fakultas berhasil dihapus secara lembut, lakukan tindakan sesuai kebutuhan
                return redirect()->back()->with('success', 'Mahasiswa berhasil dihapus dari Daftar Mahasiswa.');
            } else {
                // Jika fakultas tidak ditemukan, tampilkan pesan kesalahan
                return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
            }
        }

}
