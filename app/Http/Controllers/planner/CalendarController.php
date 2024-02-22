<?php

namespace App\Http\Controllers\planner;

use Illuminate\Http\Request;
use App\Models\planner\Holiday;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    // Method untuk mengambil data tanggal merah
    public function getHolidays(Request $request)
    {
        // Misalnya, Anda memiliki database atau sumber data lain yang menyimpan informasi tanggal hari libur
        // Di sini, Anda bisa melakukan pengecekan apakah tanggal yang diberikan berada dalam daftar hari libur

        $selectedDate = $request->input('selected_date');

        // Misalnya, Anda memiliki model Holiday yang berisi daftar tanggal hari libur
        $isHoliday = Holiday::where('date', $selectedDate)->exists();

        return response()->json(['is_holiday' => $isHoliday]);
    }
}