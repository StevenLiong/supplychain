@extends('layout.layoutmr.wraplayoutmr')

@section('title', 'materialrequest')
@section('contentmr')

<p style="font-size: 23px; color: black;">Material Request</p>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-4" style="border-left-color: red; border-left-width: 10px;">
            <div class="card-body shadow">
                <h6 class="text-start font-weight-bold " style="color: black;">Form Pengisian Pembuatan Material Request Pada Halaman Ini.</h6>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card border border-danger border-2 p-4 rounded-4">
            <form>
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kolom Panjang 1</label>
                            <input type="text" class="form-control" id="exampleField1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Kolom Panjang 2</label>
                            <input type="text" class="form-control" id="exampleField2">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleInputName" class="form-label">Kolom Panjang 3</label>
                            <input type="text" class="form-control" id="exampleField3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kolom Panjang 1</label>
                            <input type="text" class="form-control" id="exampleField1">
                        </div>
                    </div>
                    <div class="col-md-4"></div> <!-- Kolom kosong di tengah -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleInputName" class="form-label">Kolom Panjang 3</label>
                            <input type="text" class="form-control" id="exampleField3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kolom Panjang 1</label>
                            <input type="text" class="form-control" id="exampleField1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Kolom Panjang 2</label>
                            <input type="text" class="form-control" id="exampleField2">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleInputName" class="form-label">Kolom Panjang 3</label>
                            <input type="text" class="form-control" id="exampleField3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kolom Panjang 1</label>
                            <input type="text" class="form-control" id="exampleField1">
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <button type="button" class="btn btn-secondary">Secondary</button>
                        <button type="button" class="btn btn-secondary">Secondary</button>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleInputName" class="form-label">Kolom Panjang 3</label>
                            <input type="text" class="form-control" id="exampleField3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="longText" class="form-label">Teks Panjang</label>
                            <textarea class="form-control scrollable-textarea" id="longText" name="longText" placeholder="Masukkan teks panjang Anda di sini"></textarea>
                        </div>
                    </div>
                    <div class="col-md-2"></div> <!-- Kolom kosong di tengah -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleInputName" class="form-label">Kolom Panjang 3</label>
                            <input type="text" class="form-control" id="exampleField3">
                        </div>
                    </div>
                </div>
            </form>
            <div class="d-flex justify-content-center" style="position: relative; right: 60px;">
                <button type="button" class="btn btn-lg btn-danger">Danger</button>
            </div>

        </div>
    </div>
</div>


@endsection