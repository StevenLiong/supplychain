<?php

namespace App\Exports;

use App\Models\planner\Wo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;



class WoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
            return [
                'Nomor' => $counter++,
                'id_wo' => $row['id_wo'],
                'id_boms' => $row['id_boms'],
                'id_fg' => $row['id_fg'],
                'id_so' => $row['id_so'],
                'id_standardize_work' => $row->standardize_work ? $row->standardize_work->kd_manhour : 'N/A', // Asumsi ada relasi `standardize_work`
                'kva' => $row['kva'],
                'qty_trafo' => $row['qty_trafo'],
                'keterangan' => $row['keterangan'],
                'start_date' => $row['start_date'],
                'finish_date' => $row['finish_date'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Kode Work Order',
            'Kode Bill of Material',
            'Kode Finish Good',
            'Kode SO',
            'Man Hour Code',
            'KVA',
            'Quantity Trafo',
            'Keterangan',
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
