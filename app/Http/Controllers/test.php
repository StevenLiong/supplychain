<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class test extends Controller
{
    if ($ketersediaanMPREPAIR != 0 && $ketersediaanMPREPAIR < $kebutuhanMPREPAIR) {
        switch ($periode) {
            case 1: //bulanan
                $overtimeREPAIR = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 173 * 0.93);
                break;
            case 2: //3 minggu
                $overtimeREPAIR = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 120 * 0.93);
                break;
            case 3: //2 minggu
                $overtimeREPAIR = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 80 * 0.93);
                break;
            case 4: //1 minggu
                $overtimeREPAIR = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 40 * 0.93);
                break;
        }
    } elseif ($ketersediaanMPREPAIR != 0) {
        switch ($periode) {
            case 1: //bulanan
                $overtimeREPAIRold = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 173 * 0.93);
                $overtimeREPAIR = number_format($overtimeREPAIRold / ($ketersediaanMPREPAIR * 173 * 0.93) * 100, 2);
                break;
            case 2: //3 minggu
                $overtimeREPAIRold = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 120 * 0.93);
                $overtimeREPAIR = number_format($overtimeREPAIRold / ($ketersediaanMPREPAIR * 120 * 0.93) * 100, 2);
                break;
            case 3: //2 minggu
                $overtimeREPAIRold = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 80 * 0.93);
                $overtimeREPAIR = number_format($overtimeREPAIRold / ($ketersediaanMPREPAIR * 80 * 0.93) * 100, 2);
                break;
            case 4: //1 minggu
                $overtimeREPAIRold = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 80 * 0.93);
                $overtimeREPAIR = number_format($overtimeREPAIRold / ($ketersediaanMPREPAIR * 80 * 0.93) * 100, 2);
                break;
        }
    } else {
        $overtimeREPAIR = 0; // Default value if $ketersediaanMPPL is zero
    }
}
