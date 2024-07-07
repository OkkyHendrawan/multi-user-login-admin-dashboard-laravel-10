<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\WhatsAppMessageModel;
use Illuminate\Support\Facades\Validator;

class WhatsAppController extends Controller
{
    public function index()
    {
        $messages = WhatsAppMessageModel::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.whatsapp.whatsapp', compact('messages'));
    }

    public function sendWhatsAppMessage(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'message' => 'required|string',
            'file' => 'nullable|file|max:4048', // Validasi untuk file (opsional, max 2MB)
        ]);

        // Jika validasi gagal, kirim respon error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data dari request
        $phone = $request->input('phone');
        $message = $request->input('message');
        $filePath = null;

        // Cek apakah ada file yang diunggah
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('wa_file'), $fileName); // Pindahkan file ke folder public/wa_file
            $filePath = 'wa_file/' . $fileName; // Path relatif ke folder public
        }

        try {
            // Simpan informasi pesan ke database
            $whatsappMessage = new WhatsAppMessageModel();
            $whatsappMessage->whatsapp_nomor = $phone;
            $whatsappMessage->whatsapp_pesan = $message;
            $whatsappMessage->whatsapp_file = $filePath; // Simpan path file
            $whatsappMessage->save();

            // Kirim pesan WhatsApp
            $response = $this->sendWhatsApp($phone, $message, $filePath);

            // Handle respons dari pengiriman pesan
            if ($response) {
                return redirect()->back()->with('success', 'Pesan berhasil dikirim');
            } else {
                throw new Exception('Gagal mengirim pesan');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim pesan: ' . $e->getMessage());
        }
    }

    private function sendWhatsApp($phone, $message, $filePath = null)
    {
        $curl = curl_init();

        // Data untuk dikirim sebagai Curl request
        $data = [
            'target' => $phone,
            'message' => $message,
            'countryCode' => '62', // Kode negara (misalnya 62 untuk Indonesia)
        ];

        // Tambahkan file jika ada
        if ($filePath) {
            $filePath = public_path($filePath); // Path ke file di server
            $cFile = new \CURLFile($filePath); // Buat CURLFile dari path file
            $data['file'] = $cFile;
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data, // Kirim array data secara langsung
            CURLOPT_HTTPHEADER => array(
                'Authorization: iHe4yDdn@xz!MLcpMRZf', // Ganti YOUR_TOKEN dengan token autentikasi yang valid
                'Content-Type: multipart/form-data' // Tambahkan header multipart/form-data
            ),
        ));

        // Eksekusi Curl request
        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            throw new Exception($error);
        }

        return $response;
    }
}
