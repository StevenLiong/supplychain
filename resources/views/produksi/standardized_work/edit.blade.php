@extends('produksi.standardized_work.layout')
@section('content')
        <div class="card my-3">
            <div class="card-body">
                <div class="row justify-content-center mb-1">
                    @php
                        $kategori = null;

                        if ($product->dry_cast_resin) {
                            $kategori = $product->dry_cast_resin->kategori;
                        } elseif ($product->dry_non_resin) {
                            $kategori = $product->dry_non_resin->kategori;
                        } elseif ($product->repair) {
                            $kategori = $product->repair->kategori;
                        } elseif ($product->oil_custom) {
                            $kategori = $product->oil_custom->kategori;
                        } elseif ($product->oil_standard) {
                            $kategori = $product->oil_standard->kategori;
                        } elseif ($product->vt) {
                            $kategori = $product->vt->kategori;
                        } elseif ($product->ct) {
                            $kategori = $product->ct->kategori;
                        }
                        // dd($kategori);
                    @endphp
                    @if ($kategori == 5)
                        <x-editdryresin :id="$kd_manhour" :kategori="$kategori" />
                    @elseif($kategori == 6)
                        <x-editdrynonresin :id="$kd_manhour" :kategori="$kategori" />
                    @endif

                </div>
            </div>
        </div>
        
@endsection
