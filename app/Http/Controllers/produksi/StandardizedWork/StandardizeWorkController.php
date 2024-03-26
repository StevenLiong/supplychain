<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

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


        if($category == 'all'){
            $standardize_works = StandardizeWork::all();
        }else{
            $standardize_works = StandardizeWork::where('nama_product', $category)->get();
        }
        $title = 'Home';
        return view('produksi.standardized_work.dashboard', ['standardize_works' => $standardize_works,'title' => $title]);
    }


    public function destroy(string $kd_manhour): RedirectResponse
    {

        StandardizeWork::where('kd_manhour', $kd_manhour)->delete();

    // Delete records in other tables based on kd_manhour
    DryCastResin::where('kd_manhour', $kd_manhour)->delete();
    DryNonResin::where('kd_manhour', $kd_manhour)->delete();
    Ct::where('kd_manhour', $kd_manhour)->delete();
    Vt::where('kd_manhour', $kd_manhour)->delete();
    OilCustom::where('kd_manhour', $kd_manhour)->delete();
    OilStandard::where('kd_manhour', $kd_manhour)->delete();
    Repair::where('kd_manhour', $kd_manhour)->delete();

    // Redirect with success message if deletion successful
    return redirect(route('home'))->with('success', 'Deleted!');

        return redirect(route('home'))->with('error', 'Sorry, unable to delete this!');
    }
}
