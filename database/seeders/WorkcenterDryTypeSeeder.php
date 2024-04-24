<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\planner\WorkcenterDryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WorkcenterDryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_workcenter'=>'Bill Of Material'],
            ['nama_workcenter'=>'Insulation Paper'],
            ['nama_workcenter'=>'Supply Material Insulation & Coil'],
            ['nama_workcenter'=>'Supply Material Moulding'],
            ['nama_workcenter'=>'LV Windling'],
            ['nama_workcenter'=>'HV Windling'],
            ['nama_workcenter'=>'Core'],
            ['nama_workcenter'=>'Supply Fixing Parts & Core'],
            ['nama_workcenter'=>'Moulding'],
            ['nama_workcenter'=>'Susun Core'],
            ['nama_workcenter'=>'Supply Material Connection & Final Assembly'],
            ['nama_workcenter'=>'Connection & Final Assembly'],
            ['nama_workcenter'=>'Finishing'],
            ['nama_workcenter'=>'Quality Control'],
            ['nama_workcenter'=>'Quality Control Transfer Gudang'],
        ];

        foreach($data as $workCenterDry){
            WorkcenterDryType::create($workCenterDry);
        }
    }
}