<?php

namespace App\Charts;

use Illuminate\Support\Carbon;
use App\Models\logistic\Incoming;
use ArielMejiaDev\LarapexCharts\LineChart;
use ArielMejiaDev\LarapexCharts\LinezChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MontlyIncomingChart
{
    protected $chart;
    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): LineChart
    {
        // Mengambil data kedatangan material setiap bulan
        $monthlyIncomingData = Incoming::selectRaw('COUNT(*) as total_kedatangan, MONTH(tgl_kedatangan) as bulan')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Mendapatkan nama-nama bulan
        $bulanLabels = $this->generateMonthLabels();

        // Mengelompokkan data kedatangan per bulan
        $dataPerBulan = $monthlyIncomingData->pluck('total_kedatangan')->toArray();

        return $this->chart->lineChart()
            ->setTitle('Kedatangan Selama 2023')
            ->setSubtitle('Jumlah kedatangan')
            ->addData('Jumlah kedatangan', $dataPerBulan)
            ->setColors(['#E42D2D', '#E42D2D'])
            ->setHeight(250)
            ->setXAxis($bulanLabels->values()->all());
    }
    private function generateMonthLabels()
    {
        // Mendapatkan nama-nama bulan
        $bulanLabels = Incoming::selectRaw('DISTINCT MONTH(tgl_kedatangan) as bulan')
            ->orderBy('bulan')
            ->pluck('bulan');

        // Mengonversi nilai bulan menjadi nama bulan
        return $bulanLabels->map(function ($bulan) {
            return Carbon::create()->month($bulan)->format('F');
        });
    }
}
