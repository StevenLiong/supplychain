<?php

namespace Database\Seeders;

use App\Models\planner\WorkcenterOilTrafo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkcenterOilTrafoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_workcenter'=>'Insulation Paper'],
            ['nama_workcenter'=>'Supply Material Paper & Coil'],
            ['nama_workcenter'=>'Core & Fixing Parts'],
            ['nama_workcenter'=>'Supply Stacking Core (Produksi)'],
            ['nama_workcenter'=>'LV Windling'],
            ['nama_workcenter'=>'HV Windling'],
            ['nama_workcenter'=>'Core Coil Assembly'],
            ['nama_workcenter'=>'Supply Material Connection'],
            ['nama_workcenter'=>'Connection'],
            ['nama_workcenter'=>'Supply Tangki'],
            ['nama_workcenter'=>'Supply Material Final Assembly & Finishing'],
            ['nama_workcenter'=>'Oven'],
            ['nama_workcenter'=>'Final Assembly'],
            ['nama_workcenter'=>'Finishing'],
            ['nama_workcenter'=>'Quality Control'],
            ['nama_workcenter'=>'Quality Control Transfer ke Gudang'],
        ];
        
        foreach($data as $workCenteroli){
            WorkcenterOilTrafo::create($workCenteroli);
        }
    }
}