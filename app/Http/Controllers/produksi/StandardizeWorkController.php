<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\StandardizeWork;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class StandardizeWorkController extends Controller
{
    public function index(): Response
    {
        if (auth()->check()) {
            $standardize_works = StandardizeWork::all();
            return response(view('produksi.standardized_work.dashboard', ['standardize_works' => $standardize_works]));
        }
        return view('auth.login');
    }
    //delete data standar manhour
    public function destroy(string $id): RedirectResponse
    {
        // Cari "Dryresin" berdasarkan ID
        $dryresin = DryCastResin::findOrFail($id);

        // Cari entri "Standardize" yang memiliki "dryresin_id" yang sesuai
        $standardize_works = StandardizeWork::where('id_dry_cast_resin', $id)->first();

        // Hapus "Standardize" terlebih dahulu jika ditemukan
        if ($standardize_works) {
            $standardize_works->delete();
        }

        // Kemudian hapus "Dryresin" itu sendiri
        if ($dryresin->delete()) {
            return redirect(route('home'))->with('success', 'Deleted!');
        }

        return redirect(route('home'))->with('error', 'Sorry, unable to delete this!');
    }
}
