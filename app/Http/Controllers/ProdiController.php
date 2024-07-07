<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use App\Models\FakultasModel;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProdiController extends Controller
{
    public function index()
        {
            $prodi = ProdiModel::getProdi();
            $data['header_tittle']= "Daftar Prodi";
            return view('admin.prodi.list', compact('prodi'), $data);
    }

    public function generatePDF()
        {
            $data['getRecord'] = ProdiModel::where('is_delete', 0)->get();
            $dompdf = new Dompdf();
            $html = view('admin.prodi.pdf', $data)->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to Browser
            $dompdf->stream('Daftar Prodi.pdf');

    }

    public function generateExcel()
        {
        // Mengambil data admin
        $getRecord = ProdiModel::where('is_delete', 0)->get();

        // Membuat instance Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menuliskan header kolom
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Kode');
        $sheet->setCellValue('C1', 'Nama Prodi');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Di buat oleh');
        $sheet->setCellValue('F1', 'Tanggal Buat');
        $sheet->setCellValue('G1', 'Di update oleh');
        $sheet->setCellValue('H1', 'Tanggal Update');
        $sheet->setCellValue('I1', 'Di hapus oleh');

        // Menuliskan data admin
        $row = 2;
        foreach ($getRecord as $record) {
        $sheet->setCellValue('A' . $row, $record->prodi_id);
        $sheet->setCellValue('B' . $row, $record->prodi_kode);
        $sheet->setCellValue('C' . $row, $record->prodi_nama);
        $sheet->setCellValue('D' . $row, $record->prodi_status);
        $sheet->setCellValue('E' . $row, $record->created_by);
        $sheet->setCellValue('F' . $row, $record->created_at);
        $sheet->setCellValue('G' . $row, $record->updated_by);
        $sheet->setCellValue('H' . $row, $record->updated_at);
        $sheet->setCellValue('I' . $row, $record->deleted_by_name);
        $row++;
        }

        // Mengatur format dan tipe file Excel
        $writer = new Xlsx($spreadsheet);

        // Menghasilkan file Excel
        $filename = 'Daftar Prodi.xlsx';
        $writer->save($filename);

        // Mengirim file Excel ke browser
    return response()->download($filename)->deleteFileAfterSend(true);

    }

    public function form_create()
        {
        $data['daftarFakultas'] = FakultasModel::daftarFakultas();
        $data['header_tittle']= "Tambah Prodi";
        return view('admin.prodi.add', $data);

    }

    public function proses_create(Request $request)
        {
            // Validasi input
            $request->validate([
                'prodi_kode' => 'required|unique:prodi,prodi_kode',
                'prodi_nama' => 'required',
                'fakultas_id' => 'required',
                'prodi_status' => 'required',
            ]);

            // Memeriksa keunikan nilai dosen_npp sebelum menyisipkan data baru
            $existingKode = ProdiModel::where('prodi_kode', $request->prodi_kode)->first();
            if ($existingKode) {
                return redirect()->back()->withInput()->withErrors(['prodi_kode' => 'Kode sudah ada dalam database.']);
            }

            // Buat objek ProdiModel
            $prodi = new ProdiModel();
            $prodi->prodi_kode = trim($request->prodi_kode);
            $prodi->prodi_nama = $request->prodi_nama;
            $prodi->prodi_fakultas_id = $request->fakultas_id;
            $prodi->prodi_status = $request->prodi_status;
            $prodi->is_delete = 0;
            $prodi->created_by = Auth::user()->name;

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $prodi->created_at = $currentDateTime;
            $prodi->updated_at = $currentDateTime;

            // Simpan prodi ke dalam database
            $prodi->save();

            // Redirect dengan pesan sukses
        return redirect()->route('admin.prodi.list')->with('success', 'Prodi Berhasil di Tambahkan di Daftar Prodi');

    }


        public function edit($prodi_id)
        {
            $prodi = ProdiModel::findOrFail($prodi_id);
            $data['header_tittle']= "Edit Data Prodi";
            $data['getFakultas'] = FakultasModel::getFakultas();
            return view('admin.prodi.edit', compact('prodi'), $data);
        }

    public function update(Request $request, $prodi_id)
        {
            $request->validate([
                'prodi_kode' => 'required|unique:prodi,prodi_kode',
                'prodi_nama' => 'required',
                'prodi_status' => 'required|in:active,inactive',
            ]);

            $prodi = ProdiModel::findOrFail($prodi_id);
            $prodi->update($request->all());
            $prodi->updated_by = Auth::user()->name;

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $prodi->created_at = $currentDateTime;
            $prodi->updated_at = $currentDateTime;

            $prodi->save();

            return redirect()->route('admin.prodi.list')->with('success', 'Prodi Berhasil di Perbarui di Daftar Prodi');
        }

    public function softDeleteProdi($prodi_id)
        {
            // Panggil metode softDeleteFakultas dari model FakultasModel
            $prodi = ProdiModel::softDeleteProdi($prodi_id);

            if ($prodi) {
                // Jika fakultas berhasil dihapus secara lembut, lakukan tindakan sesuai kebutuhan
                return redirect()->back()->with('success', 'Prodi berhasil dihapus dari Daftar Prodi.');
            } else {
                // Jika fakultas tidak ditemukan, tampilkan pesan kesalahan
                return redirect()->back()->with('error', 'Prodi tidak ditemukan.');
            }
        }

}
