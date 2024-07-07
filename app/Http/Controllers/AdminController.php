<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $admin = User::getAdmin();
        $data['header_tittle']= "Daftar Admin";
        return view('admin.admin.list', compact('admin'), $data);
    }

    public function form_create()
    {
        $data['header_tittle']= "Tambah Admin";
        return view('admin.admin.add', $data);
    }


    public function proses_create(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users'
        ]);

        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = 1;

        // Pastikan folder public/admin sudah ada, jika tidak, buat folder tersebut
        if (!File::exists(public_path('admin'))) {
            File::makeDirectory(public_path('admin'), 0777, true, true);
        }

        // Simpan file foto ke folder admin
        if ($request->hasFile('photo_path')) {
            $photo = $request->file('photo_path');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('admin'), $photoName); // Pindahkan file ke folder public/admin
            $user->foto_path = $photoName; // Simpan nama file foto ke database
        }

        // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
        $currentDateTime = Carbon::now('Asia/Jakarta');
        $user->created_at = $currentDateTime;

        // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
        $currentDateTime = Carbon::now('Asia/Jakarta');
        $user->updated_at = $currentDateTime;

        $user->save();

        return redirect()->route('admin.admin.list')->with('success', 'Admin Berhasil di Tambahkan di Daftar Admin');
    }




    public function edit($id)
    {
        $user = User::findOrFail($id);
        $data['header_tittle']= "Edit Data Admin";
        $data['getRecord'] = $user;
        if (!empty($data['getRecord'])) {
            return view('admin.admin.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        // Validasi request
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui nama dan email user
        $user->name = trim($request->name);
        $user->email = trim($request->email);

        // Perbarui password jika diinput
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        // Perbarui foto jika diunggah
        if ($request->hasFile('admin_foto')) {
            // Hapus foto lama jika ada
            if ($user->foto_path && File::exists(public_path('admin/' . $user->foto_path))) {
                File::delete(public_path('admin/' . $user->foto_path));
            }

            // Simpan foto yang diunggah
            $photo = $request->file('admin_foto');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('admin'), $photoName);
            $user->foto_path = $photoName;
        }

        // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
        $currentDateTime = Carbon::now('Asia/Jakarta');
        $user->updated_at = $currentDateTime;

        // Simpan perubahan pada user
        $user->save();

        // Redirect ke halaman admin list dengan pesan sukses
        return redirect()->route('admin.admin.list')->with('success', 'Admin Berhasil di Perbarui dari Daftar Admin');
    }



    public function delete($id)
    {
        $user = User::getSingle($id);
        $user->is_delete = 1;
        $user->save();

        return redirect()->route('admin.admin.list')->with('success', 'Admin berhasil dihapus dari Daftar Admin.');

    }

    public function preview($id)
{
    $admin = User::findOrFail($id);
    $data['admin'] = $admin;
    $data['header_title'] = "Preview Admin";
    return view('admin.admin.preview', $data);
}

public function generateExcel()
{
    // Mengambil data admin
    $getRecord= user::where('is_delete', 0)->get();

    // Membuat instance Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menuliskan header kolom
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Full Name');
    $sheet->setCellValue('C1', 'Email');
    $sheet->setCellValue('D1', 'Create Date');
    $sheet->setCellValue('E1', 'Update Date');

    // Menuliskan data admin
    $row = 2;
    foreach ($getRecord as $record) {
        $sheet->setCellValue('A' . $row, $record->id);
        $sheet->setCellValue('B' . $row, $record->name);
        $sheet->setCellValue('C' . $row, $record->email);
        $sheet->setCellValue('D' . $row, $record->created_at);
        $sheet->setCellValue('E' . $row, $record->updated_at);
        $row++;
    }

    // Mengatur format dan tipe file Excel
    $writer = new Xlsx($spreadsheet);

    // Menghasilkan file Excel
    $filename = 'Daftar Admin.xlsx';
    $writer->save($filename);

    // Mengirim file Excel ke browser
    return response()->download($filename)->deleteFileAfterSend(true);
}

public function generatePDF()
    {
        $data['getRecord'] = user::where('is_delete', 0)->get();

        $dompdf = new Dompdf();
        $html = view('admin.admin.pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('Daftar Admin.pdf');
    }

    public function search(Request $request)
{
    $query = User::query();

    if ($request->has('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->has('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    $getRecord = $query->paginate(1);

    return view('admin.admin.list', compact('getRecord'));
}

}
