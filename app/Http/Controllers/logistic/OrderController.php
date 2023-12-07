<?php

namespace App\Http\Controllers\logistic;

use App\Models\planner\Wo;
use App\Models\planner\Bom;
use Illuminate\Http\Request;
use App\Models\logistic\Order;
use App\Models\planner\Detailbom;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::with('wo')->latest()->paginate(5);
        $search = strtolower(request('search'));
        if ($search) {
            $order = Order::where('no_bon', 'like', '%' . $search . '%')->paginate(5);
        }
      
        return view('logistic.services.transaksigudang.order', compact('order'));
    }

    public function create()
    {
        // $idBomsList = DetailBom::distinct('id_boms')->pluck('id_boms')
        $wo = Wo::all();
        $workcenter = Detailbom::all();
        // Dapatkan data dari session
        $detailbom = session()->get('detailbom');
        $dataBom = session()->get('dataBom');
        return view('logistic.services.transaksigudang.createOrder', compact('wo', 'workcenter', 'detailbom', 'dataBom'));
    }

    public function store(Request $request)
    {
        Order::create([
            'id_wo' => $request->input('id_wo'),
            'nama_workcenter' => $request->input('nama_workcenter'),
            'tanggal_bon' => $request->input('tanggal_bon'),
        ]);

        // Setelah menyimpan Order, dapatkan data yang sesuai
        $nama_workcenter = $request->input('nama_workcenter');
        $dataBom = Order::where('nama_workcenter', $nama_workcenter)->first();

        // Ambil daftar material yang sudah ada
        $detailbom = Detailbom::where('nama_workcenter', $nama_workcenter)
            ->orderBy('id', 'asc')
            ->paginate(5);

        session()->flash('detailbom', $detailbom);
        session()->flash('dataBom', $dataBom);

        return redirect('services/transaksigudang/order/create');
    }

    public function show($nama_workcenter)
    {
        $dataBom = Order::where('nama_workcenter', $nama_workcenter)->first(); // Ubah query untuk mengambil BOM yang sesuai
        session(['nama_workcenter' => $nama_workcenter]);

         $detailbom = Detailbom::with('order')
            ->where('nama_workcenter', $nama_workcenter)
            ->orderBy('id', 'asc')
            ->paginate(5);
       
        return view('logistic.services.transaksigudang.detailorder', compact('detailbom', 'dataBom'));
    }



    public function destroy($id){

        $order = Order::find($id);
        $order->delete($order->id);
        return redirect('services/transaksigudang/order')->with('success', 'Berhasil menghapus order');
    }
}
 