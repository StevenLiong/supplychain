@extends('produksi.standardized_work.layout')
@section('content')
    <div class="container">
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
                    <div class="col-lg-2 col-sm-2 col-md-2 text-left">
                        <a href="/standardized_work/home" class="btn btn-secondary mt-2 ">
                            <i class="fa-solid fa-circle-xmark mr-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
