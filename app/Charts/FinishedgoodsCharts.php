<?php

namespace App\Charts;

use App\Models\logistic\Finishedgood;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class FinishedgoodsCharts
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {

        // mengambil data fg
        $total = Finishedgood::count();
        return $this->chart->pieChart()
            ->setTitle('Data Finished Per kVA')
            ->setTitle('Total Finishedgood :'. $total )
            ->addData([
                Finishedgood::where('kva', 250000)->count(),
                Finishedgood::where('kva', 500000)->count(),
                Finishedgood::where('kva', 100000000)->count(),
                Finishedgood::where('kva', 150000000)->count(),
                Finishedgood::where('kva', 200000000)->count(),
            ])
            ->setHeight(200)
            ->setLabels(['250000 kVA', '500000 kVA', '100000000 kVA', '150000000 kVA', '200000000 kVA']);
    }
}
