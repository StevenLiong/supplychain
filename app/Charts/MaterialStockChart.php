<?php

namespace App\Charts;

use App\Models\logistic\Material;
use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MaterialStockChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): BarChart
    {
        // Ambil data top 5 material dengan jumlah stok terbanyak
        $topMaterialsData = Material::orderBy('jumlah')->limit(5)->get();

        // dd($topMaterialsData);
        // Kelompokkan data material dan stok
        $materialLabels = $topMaterialsData->pluck('nama_material');
        $stockData = $topMaterialsData->pluck('jumlah');

        $data = [];

        foreach ($materialLabels as $index => $label) {
            $data[] = ['x' => $label, 'y' => $stockData[$index]];
        }

        return $this->chart->barChart()
            ->setTitle('Material dengan Stok Terendah')
            ->setSubtitle('Stok Material')
            ->setColors(['#E42D2D', '#E42D2D'])
            ->addData('Stok', $data)
            ->setXAxis($materialLabels->toArray())
            ->setHeight(250);
    }
}
