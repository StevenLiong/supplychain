<?php

namespace App\Http\Controllers\planner;

use App\Imports\FinishgoodImport;
use App\Mail\FinishGoodNotification;
use App\Models\planner\Stock;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaterialPendingNotification;
use App\Models\planner\Kanbanfg;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FinishgoodController extends Controller
{
    public function indexFg()
    {
        $detailFg = Kanbanfg::all();
        $this->emailNotif();
        return view('planner.finishgood.index', compact('detailFg'));
    }
    public function formUpload()
    {
        return view('planner.finishgood.upload-fg');
    }

    public function upload(Request $request){

        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Ambil file yang diunggah dari request
        $file = $request->file('file');

        // Buat instance BomImport dengan menyediakan idBom
        $import = new FinishgoodImport();

        // Import data dari file Excel
        Excel::import($import, $file);
            return redirect('/FinishGood/IndexFG');
    }

    public function destroy()
    {
        // Hapus semua data dari tabel stock
        Kanbanfg::truncate();

        return redirect()->back();
    }

    // public function emailNotif()
    // {
    //     // Dapatkan catatan kanbanfg yang memenuhi kriteria
    //     $notifFg = Kanbanfg::where('email_status', 0)->where('status', 'Order')->get();

    //     if ($notifFg->count() > 0) {
    //         $subjekEmail = "Finish Good Out Of Limit Kanban";

    //         // Loop melalui setiap Detailbom untuk mendapatkan informasi Stock
    //         foreach ($notifFg as $kanbanfg) {
    //             // Pastikan bahwa email belum dikirimkan sebelumnya
    //             if ($kanbanfg->email_status == 1) {
    //                 continue; // Lanjutkan ke iterasi berikutnya jika email sudah dikirimkan
    //             }

    //             // Kirim email ke alamat yang ditentukan
    //             // Ambil alamat email penerima
    //             $alamatEmailPenerima = ['stevenliong83@gmail.com', 'steven.naga15@gmail.com'];
    //             Mail::to($alamatEmailPenerima)->send(new FinishGoodNotification(
    //                 $subjekEmail,
    //                 $notifFg // Kirim satu data kanbanfg ke notifikasi
    //             ));

    //             // Perbarui status email_status menjadi 1 untuk material yang telah dikirimkan
    //             $kanbanfg->update(['email_status' => 1]);
    //         }
    //     }
    // }

    public function emailNotif()
    {
        // Dapatkan catatan kanbanfg yang memenuhi kriteria
        $notifFg = Kanbanfg::where('email_status', 0)->where('status', 'Order')->get();

        if ($notifFg->count() > 0) {
            $subjekEmail = "Finish Good Out Of Limit Kanban";

            // Kumpulkan semua informasi dari $notifFg
            $dataFg = $notifFg->map(function ($kanbanfg) {
                return [
                    'kode_fg' => $kanbanfg->kode_fg,
                    'nama_item' => $kanbanfg->nama_item,
                    'stock_on_hand' => $kanbanfg->stock_on_hand,
                    'max_kanban' => $kanbanfg->max_kanban,
                    'unit' => $kanbanfg->unit,
                    'status' => $kanbanfg->status,
                    'realisasi' => $kanbanfg->realisasi,
                ];
            });

            // Kirim satu email yang berisi semua informasi
            $alamatEmailPenerima = ['stevenliong83@gmail.com', 'steven.naga15@gmail.com'];
            Mail::to($alamatEmailPenerima)->send(new FinishGoodNotification(
                $subjekEmail,
                $dataFg
            ));

            // Perbarui status email_status menjadi 1 untuk setiap data yang telah dikirimkan
            foreach ($notifFg as $kanbanfg) {
                $kanbanfg->update(['email_status' => 1]);
            }
        }
    }


   
}