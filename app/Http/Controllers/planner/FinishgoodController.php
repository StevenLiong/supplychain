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
use App\Models\planner\Fgoods;
use App\Models\planner\Kanbanfg;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FinishgoodController extends Controller
{
    // public function indexFg()
    // {
    //     $detailFg = Kanbanfg::all();
    //     $this->emailNotif();
    //     return view('planner.finishgood.index', compact('detailFg'));
    // }

    public function indexFg()
    {
        $detailFg = Kanbanfg::all();
        // dd($detailFg);

        // $stockonhand = $detailFg='stock_on_hand';
        // dd($stockonhand);

        $this->emailNotif();
        return view('planner.finishgood.index', compact('detailFg'));
    }

    // public function indexFg()
    // {
    //     $detailFg = Kanbanfg::all();

    //     // Check for changes in fgoods table based on qty and unit
    //     $updatedFgoodsRecords = Fgoods::all();

    //     foreach ($updatedFgoodsRecords as $updatedFgoodsRecord) {
    //         // Get previous stock_on_hand value
    //         $previousStockOnHand = Kanbanfg::where('kode_fg', $updatedFgoodsRecord->kode_fg)->first()->stock_on_hand;

    //         // Check if stock_on_hand has changed
    //         if ($previousStockOnHand != $updatedFgoodsRecord->qty) {
    //             // Check if unit has changed
    //             if ($updatedFgoodsRecord->unit != $previousStockOnHand->unit) {
    //                 // Update corresponding kanbanfgs record
    //                 $kanbanfgRecord = Kanbanfg::where('kode_fg', $updatedFgoodsRecord->kode_fg)->first();
    //                 if ($kanbanfgRecord) {
    //                     $kanbanfgRecord->stock_on_hand = $updatedFgoodsRecord->qty;
    //                     $kanbanfgRecord->email_status = 0;
    //                     $kanbanfgRecord->save();
    //                 }
    //             }
    //         }
    //     }

    //     // Update lastSyncedAt timestamp
    //     $this->lastSyncedAt = now();

    //     return view('planner.finishgood.index', compact('detailFg'));
    // }
    
    // private $lastSyncedAt;

    // public function __construct()
    // {
    //     $this->lastSyncedAt = now();
    // }

    public function formUpload()
    {
        return view('planner.finishgood.upload-fg');
    }

    public function upload(Request $request){

        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('file');
        $import = new FinishgoodImport();
        Excel::import($import, $file);
            return redirect('/FinishGood/IndexFG');
    }

    public function destroy()
    {
        Kanbanfg::truncate();

        return redirect()->back();
    }

    public function emailNotif()
    {
        $notifFg = Kanbanfg::where('email_status', 0)->where('status', 'Order')->get();

        if ($notifFg->count() > 0) {
            $subjekEmail = "Finish Good Out Of Limit Kanban";

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

            $alamatEmailPenerima = ['stevenliong83@gmail.com', 'steven.naga15@gmail.com'];
            Mail::to($alamatEmailPenerima)->send(new FinishGoodNotification(
                $subjekEmail,
                $dataFg
            ));

            foreach ($notifFg as $kanbanfg) {
                $kanbanfg->update(['email_status' => 1]);
            }
        }
    }
}