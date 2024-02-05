<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\produksi\Ct;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\DryNonResin;
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
        // dd($category);
    
        // $filteredData = StandardizeWork::where('nama_product', $category)->get();
        // dd($filteredData);
    
        if($category == 'all'){
            $standardize_works = StandardizeWork::all();
        }else{
            $standardize_works = StandardizeWork::where('nama_product', $category)->get();
        }
        // $standardize_works = StandardizeWork::where('nama_product', $category)->get();
        // dd($standardize_works);
        $title = 'Home';
        return view('produksi.standardized_work.dashboard', ['standardize_works' => $standardize_works,'title' => $title]);
    }

    // delete data standar manhour
    // public function destroy(string $id): RedirectResponse
    // {
    //     // Cari "Dryresin" berdasarkan ID
    //     $dryresin = DryCastResin::findOrFail($id);

    //     // Cari entri "Standardize" yang memiliki "dryresin_id" yang sesuai
    //     $standardize_works = StandardizeWork::where('id_dry_cast_resin', $id)->first();

    //     // Hapus "Standardize" terlebih dahulu jika ditemukan
    //     if ($standardize_works) {
    //         $standardize_works->delete();
    //     }

    //     // Kemudian hapus "Dryresin" itu sendiri
    //     if ($dryresin->delete()) {
    //         return redirect(route('home'))->with('success', 'Deleted!');
    //     }

    //     return redirect(route('home'))->with('error', 'Sorry, unable to delete this!');
    // }
    public function destroy(string $id): RedirectResponse
    {

        $dryresin = DryCastResin::find($id);
        $drynonresin = DryNonResin::find($id);
        $ct = Ct::find($id);
        $vt = Vt::find($id);
        $oilcustom = OilCustom::find($id);
        $oilstandard = OilStandard::find($id);
        $repair = Repair::find($id);


        StandardizeWork::where('id_dry_cast_resin', $id)
        ->orWhere('id_dry_non_resin', $id)
        ->orWhere('id_ct', $id)
        ->orWhere('id_vt', $id)
        ->orWhere('id_oil_standard', $id)
        ->orWhere('id_oil_custom', $id)
        ->orWhere('id_repair', $id)
        ->delete();

        // Hapus "Standardize" terlebih dahulu jika ditemukan
        // if ($standardize_works) {
        //     $standardize_works->delete();
        // }

        // Cek apakah data dryresin ada
        if ($dryresin) {
            // Hapus dryresin
            if ($dryresin->delete()) {
                return redirect(route('home'))->with('success', 'Deleted!');
            }
        } elseif ($drynonresin) {
            // Hapus drynonresin
            if ($drynonresin->delete()) {
                return redirect(route('home'))->with('success', 'Deleted!');
            }
        } elseif ($ct) {
            // Hapus ct
            if ($ct->delete()) {
                return redirect(route('home'))->with('success', 'Deleted!');
            }
        } elseif ($vt) {
            // Hapus vt
            if ($vt->delete()) {
                return redirect(route('home'))->with('success', 'Deleted!');
            }
        } elseif ($oilcustom) {
            // Hapus oilcustom
            if ($oilcustom->delete()) {
                return redirect(route('home'))->with('success', 'Deleted!');
            }
        } elseif ($oilstandard) {
            // Hapus oilstandard
            if ($oilstandard->delete()) {
                return redirect(route('home'))->with('success', 'Deleted!');
            }
        } elseif ($repair) {
            // Hapus repair
            if ($repair->delete()) {
                return redirect(route('home'))->with('success', 'Deleted!');
            }
        } else {
            // Data tidak ditemukan
            return redirect(route('home'))->with('error', 'Data not found!');
        }

        return redirect(route('home'))->with('error', 'Sorry, unable to delete this!');
    }
}
