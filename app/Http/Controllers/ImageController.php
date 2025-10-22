<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function image(Request $request)
    {
        $header = $request->header()['authorization'][0];
        $header = base64_decode($header);
        if ($header == 'main_panel:0p3n_th!sR0ute') {
            $url = json_decode($request->data);
            $tujuan_upload = $url->storage;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                // isi dengan nama folder tempat kemana file diupload
                $nama_file = $url->nama_file;
                $file->move($tujuan_upload, $nama_file);

                $fileLama = $tujuan_upload . '/' . $url->url_file;

                if (file_exists($fileLama)) {
                    if (is_file($fileLama)) {
                        unlink($fileLama);
                    } else {
                        Log::warning("Path bukan file: {$fileLama}");
                    }
                }
            }
            if ($request->hasFile('file2')) {
                $file2 = $request->file('file2');
                // isi dengan nama folder tempat kemana file diupload

                $nama_file = $url->nama_file2;
                $file2->move($tujuan_upload, $nama_file);

                $fileLama = $tujuan_upload . '/' . $url->url_file2;

                if (file_exists($fileLama)) {
                    if (is_file($fileLama)) {
                        unlink($fileLama);
                    } else {
                        Log::warning("Path bukan file: {$fileLama}");
                    }
                }
            }
            return [
                'code'      => 200,
                'response' => true,
                'message' => 'success'
            ];
        } else {
            return [
                'code'      => 200,
                'response' => false,
                'message' => 'authorization is fail!'
            ];
        }
    }

    public function hapusQr(Request $request)
    {
        $header = $request->header()['authorization'][0];
        $header = base64_decode($header);
        $fileLama = $request->nama_file;
        if ($header == 'main_panel:0p3n_th!sR0ute') {
            if (file_exists($fileLama)) {
                unlink($fileLama);
            }
            return [
                'code'      => 200,
                'response' => true,
                'message' => 'success'
            ];
        } else {
            return [
                'code'      => 200,
                'response' => false,
                'message' => 'authorization is fail!'
            ];
        }
    }
}
