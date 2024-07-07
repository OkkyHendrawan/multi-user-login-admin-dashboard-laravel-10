<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\FakultasModel;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FakultasController extends Controller
{
    public function index()

        {
            $fakultas = FakultasModel::getFakultas();
            $data['header_tittle']= "Daftar Fakultas";
            return view('admin.fakultas.list', compact('fakultas'), $data);
        }


        public function generatePDF()
        {
            $data['getRecord'] = FakultasModel::where('is_delete', 0)->get();

            $dompdf = new Dompdf();
            $html = view('admin.fakultas.pdf', $data)->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream('Daftar Fakultas.pdf');
        }



        public function generateExcel()
        {
            // Mengambil data fakultas yang tidak dihapus
            $getRecord = FakultasModel::where('is_delete', 0)->get();

            // Membuat instance Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Menuliskan header kolom
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Kode');
            $sheet->setCellValue('C1', 'Nama Fakultas');
            $sheet->setCellValue('D1', 'Status');
            $sheet->setCellValue('E1', 'Di buat oleh');
            $sheet->setCellValue('F1', 'Tanggal Buat');
            $sheet->setCellValue('G1', 'Di update oleh');
            $sheet->setCellValue('H1', 'Tanggal Update');
            $sheet->setCellValue('I1', 'Di hapus oleh');

            // Menuliskan data fakultas yang tidak dihapus
            $row = 2;
            foreach ($getRecord as $record) {
                $sheet->setCellValue('A' . $row, $record->fakultas_id);
                $sheet->setCellValue('B' . $row, $record->fakultas_kode);
                $sheet->setCellValue('C' . $row, $record->fakultas_nama);
                $sheet->setCellValue('D' . $row, $record->fakultas_status);
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
            $filename = 'Daftar Fakultas.xlsx';
            $writer->save($filename);

            // Mengirim file Excel ke browser
            return response()->download($filename)->deleteFileAfterSend(true);
        }



    public function form_create()
        {
            $data['header_tittle']= "Tambah Fakultas";
            return view('admin.fakultas.add', $data);
        }


    public function proses_create(Request $request)
        {
            // Validasi input
    $request->validate([
        'fakultas_kode' => 'required|unique:fakultas,fakultas_kode',
        'fakultas_nama' => 'required',
        'fakultas_status' => 'required',
    ]);

            $save = new FakultasModel;
            $save->fakultas_kode = $request->fakultas_kode;
            $save->fakultas_nama = $request->fakultas_nama;
            $save->fakultas_status = $request->fakultas_status;
            $save->is_delete = 0;
            $save->created_by = Auth::user()->name;

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $save->created_at = $currentDateTime;
            $save->updated_at = $currentDateTime;

            $save->save();

            return redirect()->route('admin.fakultas.list')->with('success', 'Fakultas Berhasil di Tambahkan di Daftar Fakultas');
        }

    public function edit($fakultas_id)
        {
            $fakultas = FakultasModel::findOrFail($fakultas_id);
            $data['header_tittle']= "Edit Data Fakultas";
            return view('admin.fakultas.edit', compact('fakultas'), $data);
        }

    public function update(Request $request, $fakultas_id)
        {
            $request->validate([
                'fakultas_kode' => 'required|unique:fakultas,fakultas_kode',
                'fakultas_nama' => 'required',
                'fakultas_status' => 'required',
            ]);

            $fakultas = FakultasModel::findOrFail($fakultas_id);
            $fakultas->update($request->all());
            $fakultas->updated_by = Auth::user()->name;

            // Set waktu saat ini sebagai waktu Indonesia Barat (WIB)
            $currentDateTime = now('Asia/Jakarta');
            $fakultas->created_at = $currentDateTime;
            $fakultas->updated_at = $currentDateTime;

            $fakultas->save();

            return redirect()->route('admin.fakultas.list')->with('success', 'Fakultas Berhasil di Perbarui di Daftar Fakultas');
        }

    public function softDeleteFakultas($fakultas_id)
        {
            // Panggil metode softDeleteFakultas dari model FakultasModel
            $fakultas = FakultasModel::softDeleteFakultas($fakultas_id);

            if ($fakultas) {
                // Jika fakultas berhasil dihapus secara lembut, lakukan tindakan sesuai kebutuhan
                return redirect()->back()->with('success', 'Fakultas berhasil di hapus dari Daftar Fakultas.');
            } else {
                // Jika fakultas tidak ditemukan, tampilkan pesan kesalahan
                return redirect()->back()->with('error', 'Fakultas tidak ditemukan.');
            }
        }

}
