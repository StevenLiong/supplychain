<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Http\Request;
use App\Models\logistic\Order;
use App\Models\logistic\Cutting;
use App\Models\logistic\Material;
use App\Models\planner\Detailbom;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CuttingController extends Controller
{
    public function index()
    {
        $cutting = Cutting::with('order')
            ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan kolom created_at secara descending
            ->get();
        return view('logistic.services.transaksigudang.cutting', compact('cutting'));
    }

    public function create()
    {
        $order = Order::where('status', 0)
            ->get();
        // Dapatkan data dari session
        $detailbom = session()->get('detailbom');
        $dataOrder = session()->get('dataOrder');
        // $idBomsList = DetailBom::distinct('id_boms')->pluck('id_boms');
        return view('logistic.services.transaksigudang.createCutting', compact('order', 'detailbom', 'dataOrder'));
    }

    public function store(Request $request)
    {
        // Membuat entri baru dalam tabel Cutting
        Cutting::create([
            'bon_f' => $request->input('bon_f'),
            'tanggal_bon' => $request->input('tanggal_bon'),
        ]);

        // Ambil nilai bon_f dari request
        $bonF = $request->input('bon_f');

        // Mengubah status di tabel orders dari 0 menjadi 1 berdasarkan bon_f
        Order::where('id', $bonF)->update(['status' => 1]);

        // Setelah menyimpan Cutting, dapatkan data yang sesuai
        // $nama_workcenter = Order::where('nama_workcenter', $bonF->nama_workcenter);
        // $dataBom = Order::where('nama_workcenter', $bonF->nama_workcenter)->first();

        $order = Order::where('id', $bonF)->first();


        // Ambil daftar material yang sudah ada
        $detailbom = Detailbom::where('nama_workcenter', $order->nama_workcenter)
            ->orderBy('id', 'asc')
            ->paginate(5);

        session()->flash('detailbom', $detailbom);
        session()->flash('dataOrder', $order);

        return redirect('services/transaksigudang/cutting/create');
    }

    public function show($nama_workcenter)
    {
        $dataBom = Order::where('nama_workcenter', $nama_workcenter)->first();
        if ($dataBom) {
            $detailbom = Detailbom::with('order')
                ->where('nama_workcenter', $nama_workcenter)
                ->orderBy('id', 'asc')
                ->paginate(5);

            foreach ($detailbom as $item) {
                // contoh Akses nilai-nilai yang ingin Anda tampilkan
                $orderNamaWorkcenter = $item->nama_workcenter;
                $kd_material = $item->id_materialbom;
                $usage_material = $item->usage_material;

                return view('logistic.services.transaksigudang.detailcutting', compact('dataBom', 'item'));
            }
        }
    }

    public function pendingList()
    {
        $cutting = Cutting::with('order')->where('status', 0)
            ->get();
        return view('logistic.services.transaksiproduksi.listcuttingpending', compact('cutting'));
    }

    public function showPendingList($nama_workcenter)
    {
        $dataBom = Order::where('nama_workcenter', $nama_workcenter)->first();

        if ($dataBom) {
            $detailbom = Detailbom::with('order')
                ->where('nama_workcenter', $nama_workcenter)
                ->orderBy('id', 'asc')
                ->paginate(5);

            foreach ($detailbom as $item) {
                // contoh Akses nilai-nilai yang ingin Anda tampilkan
                $orderNamaWorkcenter = $item->nama_workcenter;
                $kd_material = $item->id_materialbom;

                return view('logistic.services.transaksiproduksi.listbompending', compact('dataBom', 'item'));
            }
        }
    }

    public function cutMaterial($nama_workcenter)
    {
        $detailbom = Detailbom::with('order')
            ->where('nama_workcenter', $nama_workcenter)
            ->orderBy('id', 'asc')
            ->paginate(5);

        foreach ($detailbom as $item) {
            $orderNamaWorkcenter = $item->nama_workcenter;
            $kd_material = $item->id_materialbom;
            $usage_material = $item->usage_material;

            // Pastikan material hanya dipotong jika nama_workcenter sesuai
            if ($orderNamaWorkcenter === $nama_workcenter) {
                // Lakukan pemotongan stok sesuai kebutuhan
                $masterMaterial = Material::where('kd_material', $kd_material)->first();
                if ($masterMaterial) {
                    // Pastikan stok cukup untuk dipotong
                    if ($masterMaterial->jumlah >= $usage_material) {
                        // Lakukan pemotongan stok
                        $masterMaterial->jumlah -= $usage_material;
                        $masterMaterial->save();
                    }
                }

                // Ubah status di tabel cutting menjadi 1
                $cutting = Cutting::with('order')
                    ->whereHas('order', function ($query) use ($nama_workcenter) {
                        $query->where('nama_workcenter', $nama_workcenter);
                    })
                    ->get();

                foreach ($cutting as $cuttingItem) {
                    // Update status pada tabel cutting
                    $cuttingItem->update(['status' => 1]);
                }
            }

            return redirect('/services/transaksiproduksi/listpending')->with('success', 'Stok Material Terpotong');
        }
    }
}
