<?php

namespace App\Http\Controllers\planner;

use App\Exports\FgExport;
use App\Imports\FinishgoodImport;
use App\Mail\FinishGoodNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Models\planner\Kanbanfg;

class FinishgoodController extends Controller
{
    public function indexFg()
    {
        $detailFg = Kanbanfg::with('finishedGood')->get();

        foreach ($detailFg as $item) {
            $kanbanFg = $item;
            $kanbanFg->updateStockOnHand();
            $kanbanFg->updateStatus();
        }

        $this->emailNotif();
        return view('planner.finishgood.index', ['detailFg' => $detailFg]);
    }

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
        $notifFg = Kanbanfg::where('email_status', 0)
        ->where('status', 'Order')
        ->get();
        // $notifFg = Kanbanfg::where('email_status')

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
                    'peruntukan_unit' => $kanbanfg->peruntukan_unit,
                    'stock_akhir' => $kanbanfg->stock_akhir,
                ];
            });

            $alamatEmailPenerima = ['stevenliong83@gmail.com', 'stevenliong15@gmail.com'];
            Mail::to($alamatEmailPenerima)->send(new FinishGoodNotification(
                $subjekEmail,
                $dataFg
            ));

            foreach ($notifFg as $kanbanfg) {
                $kanbanfg->update(['email_status' => 1]);
            }
        }
    }
    public function edit(string $kode_fg) :View
    {
        $dataFg = Kanbanfg::where('kode_fg', $kode_fg)
            ->first();

        return view('planner.Finishgood.edit-fg', compact('dataFg'));
    }

    public function updateFg(Request $request, $kode_fg){
       $this->validate($request, [
           'peruntukan_unit' => 'required|integer',
       ]);
   
       $editFg = Kanbanfg::where('kode_fg', $kode_fg)->first();
   
       $editFg->update([
           'peruntukan_unit' => $request->peruntukan_unit,
       ]);
       $peruntukanunit = $request->get('peruntukan_unit');

       $editFg->stock_akhir = $editFg->stock_on_hand - $peruntukanunit;
       $editFg->save();
       
       return redirect()->route('fg-index');
   }

   public function exportToExcel()
    {
        $dataFg = Kanbanfg::select('id', 'kode_fg', 'nama_item', 'max_kanban', 'stock_on_hand', 'unit', 'status', 'peruntukan_unit', 'stock_akhir')->get();
        return Excel::download(new FgExport($dataFg), 'KanbanFg.xlsx');
    }
}