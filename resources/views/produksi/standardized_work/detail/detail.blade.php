@extends('produksi.standardized_work.layout')
@section('content')
    <div class="text-left mb-2 mt-2">
        <a href="/standardized_work/home" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back
        </a>
    </div>
    @php
        $kategori = null;
        if ($detail->dry_cast_resin) {
            $kategori = $detail->dry_cast_resin->kategori;
        } elseif ($detail->dry_non_resin) {
            $kategori = $detail->dry_non_resin->kategori;
        } elseif ($detail->repair) {
            $kategori = $detail->repair->kategori;
        } elseif ($detail->oil_custom) {
            $kategori = $detail->oil_custom->kategori;
        } elseif ($detail->oil_standard) {
            $kategori = $detail->oil_standard->kategori;
        } elseif ($detail->ctvt) {
            $kategori = $detail->ctvt->kategori;
        }
    @endphp
    @if ($kategori == 4)
        <x-detaildry :id="$kd_manhour" :kategori="$kategori" />
    @elseif($kategori == 5)
        <x-detaildrynonresin :id="$kd_manhour" :kategori="$kategori" />
    @elseif($kategori == 2)
        <x-detailoilstandard :id="$kd_manhour" :kategori="$kategori" />
    @elseif($kategori == 1)
        <x-detailoilcustom :id="$kd_manhour" :kategori="$kategori" />
    @elseif($kategori == 3)
        <x-detailctvt :id="$kd_manhour" :kategori="$kategori" />
    @elseif($kategori == 6)
        <x-detailrepair :id="$kd_manhour" :kategori="$kategori" />
    @endif
@endsection
