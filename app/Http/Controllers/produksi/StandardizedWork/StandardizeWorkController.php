<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Http\Controllers\Controller;
use App\Models\produksi\Ct;
use App\Models\produksi\CtVt;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\DryNonResin;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManHour;
use App\Models\produksi\OilCustom;
use App\Models\produksi\OilStandard;
use App\Models\produksi\Repair;
use App\Models\produksi\StandardizeWork;
use App\Models\produksi\Vt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class StandardizeWorkController extends Controller
{
    public function index(): Response
    {
        if (auth()->check()) {
            $standardize_works = StandardizeWork::all();
            $title = 'Home';
            return response(view('produksi.standardized_work.dashboard', ['standardize_works' => $standardize_works, 'title' => $title]));
        }
        return view('auth.login');
    }

    public function filterData(Request $request)
    {
        $category = $request->input('category');


        if ($category == 'all') {
            $standardize_works = StandardizeWork::all();
        } else {
            $standardize_works = StandardizeWork::where('nama_product', $category)->get();
        }
        $title = 'Home';
        return view('produksi.standardized_work.dashboard', ['standardize_works' => $standardize_works, 'title' => $title]);
    }

    public function detail(string $kd_manhour)
    {
        $detail = StandardizeWork::where('kd_manhour', $kd_manhour)->first();
        return view('produksi.standardized_work.detail.detail', ['detail' => $detail,'kd_manhour' => $kd_manhour, 'title' => 'Detail Data']);
    }

    public function destroy(string $kd_manhour): RedirectResponse
    {

        StandardizeWork::where('kd_manhour', $kd_manhour)->delete();

        // Delete records in other tables based on kd_manhour
        DryCastResin::where('kd_manhour', $kd_manhour)->delete();
        DryNonResin::where('kd_manhour', $kd_manhour)->delete();
        // Ct::where('kd_manhour', $kd_manhour)->delete();
        CtVt::where('kd_manhour', $kd_manhour)->delete();
        // Vt::where('kd_manhour', $kd_manhour)->delete();
        OilCustom::where('kd_manhour', $kd_manhour)->delete();
        OilStandard::where('kd_manhour', $kd_manhour)->delete();
        Repair::where('kd_manhour', $kd_manhour)->delete();

        // Redirect with success message if deletion successful
        return redirect(route('home'))->with('success', 'Deleted!');

        // return redirect(route('home'))->with('error', 'Sorry, unable to delete this!');
    }
        public function delete(string $kd_manhour, Request $request): RedirectResponse
    {
        StandardizeWork::where('kd_manhour', $kd_manhour)->delete();

        // Delete records in other tables based on kd_manhour
        DryCastResin::where('kd_manhour', $kd_manhour)->delete();
        DryNonResin::where('kd_manhour', $kd_manhour)->delete();
        CtVt::where('kd_manhour', $kd_manhour)->delete();
        OilCustom::where('kd_manhour', $kd_manhour)->delete();
        OilStandard::where('kd_manhour', $kd_manhour)->delete();
        Repair::where('kd_manhour', $kd_manhour)->delete();

        // Check if request is AJAX
        if ($request->ajax()) {
            // Return JSON response
            return response()->json(['success' => true]);
        } else {
            // Redirect with success message if deletion successful
            return redirect(route('home'))->with('success', 'Deleted!');
        }
    }
    public function edit(string $kd_manhour)
    {
        // Cari data Standard berdasarkan kd_manhour
        $product = StandardizeWork::where('kd_manhour', $kd_manhour)->first();

        // Jika data Standard tidak ditemukan, tampilkan error 404
        if (!$product) {
            abort(404);
        }

        // Ambil data dari relasi masing-masing produk berdasarkan kd_manhour yang sama
        $dryCastResin = DryCastResin::where('kd_manhour', $kd_manhour)->first();
        $dryNonResin = DryNonResin::where('kd_manhour', $kd_manhour)->first();
        // $ct = Ct::where('kd_manhour', $kd_manhour)->first();
        // $vt = Vt::where('kd_manhour', $kd_manhour)->first();
        $oilCustom = OilCustom::where('kd_manhour', $kd_manhour)->first();
        $oilStandard = OilStandard::where('kd_manhour', $kd_manhour)->first();
        $repair = Repair::where('kd_manhour', $kd_manhour)->first();

        // Kemudian Anda dapat mengirimkan data ini ke tampilan untuk diedit
        return view('produksi.standardized_work.edit', [
            'product' => $product,
            'dryCastResin' => $dryCastResin,
            'dryNonResin' => $dryNonResin,
            // 'ct' => $ct,
            // 'vt' => $vt,
            'oilCustom' => $oilCustom,
            'oilStandard' => $oilStandard,
            'repair' => $repair,
            'kd_manhour' => $kd_manhour,
            'title' => 'Edit Data'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kd_manhour)
    {
        $standardizeWork = StandardizeWork::where('kd_manhour', $kd_manhour)->first();

        return redirect(route('home'))->with('success', 'Produk berhasil diupdate.');
    }


}
