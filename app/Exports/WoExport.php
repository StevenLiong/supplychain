<?php

namespace App\Exports;

use App\Models\planner\Wo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;



class WoExport implements FromCollection, WithHeadings
{
    protected $dataWo;

    public function __construct($dataWo)
    {
        $this->dataWo = $dataWo;
    }

    public function collection()
    {
        $counter = 1;

        return collect($this->dataWo)->map(function ($row) use (&$counter) {
            // Set 'Nomor' column as the first column
            // dd($dataWo);
            return [
                'Nomor' => $counter++,
                'id_boms' => $row['id_boms'],
                'id_wo' => $row['id_wo'],
                'id_fg' => $row['id_fg'],
                'id_so' => $row['id_so'],
                'kva' => $row['kva'],
                'qty_trafo' => $row['qty_trafo'],
                'start_date' => $row['start_date'],
                'finish_date' => $row['finish_date'],
                // 'Nomor' => $counter++,
                // 'Kode Bill of Material' => $row['Kode Bill of Material'],
                // 'Kode Work Order' => $row['Kode Work Order'],
                // 'Quantity Trafo' => $row['Quantity Trafo'],
                // 'Kode SO' => $row['Kode SO'],
                // 'Start Date' => $row['Start Date'],
                // 'Finish Date' => $row['Finish Date'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Kode Bill of Material',
            'Kode Work Order',
            'Kode Finish Good',
            'Kode SO',
            'KVA',
            'Quantity Trafo',
            'Start Date',
            'Finish Date',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle(
                    $event->sheet->calculateWorksheetDimension()
                )->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                $event->sheet->getDelegate()->getStyle('A1:W1')->getFont('')->setSize(12);
            },
        ];
    }
}
