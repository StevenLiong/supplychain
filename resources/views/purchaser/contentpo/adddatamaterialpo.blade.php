@extends('purchaser.layout.layoutpo.wraplayoutpo')

@section('title', 'purchaseorder')
@section('contentpo')


<div>
    <div class="container d-flex justify-content-center align-items-center">
        <img src="/Assets/LogoTrafoindo.png" alt="Centered Image" style="width: 235px;">
    </div>

    <p style="font-size: 23px; color: black;">Purchase Order</p>
    <div class="row">
        <div class="col-md-12">
            <div class="card rounded-4" style="border-left-color: red; border-left-width: 10px;">
                <div class="card-body">
                    <h6 class="text-start font-weight-bold " style="color: black;">Form Pengisian Pembuatan Purchase Order Pada Halaman Ini.</h6>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row ">
        <div class="col-md-12">
            <div class="card border border-danger border-2 p-4 rounded-4">
                <form action="/purchaseorder/{{$po->id_mr}}/add" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nomer PO</label>
                                <input type="text" class="form-control" id="exampleField1" value="{{$id}}" name="id_po" readonly>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" value="{{$now->toDateString()}}" placeholder="Masukan Tanggal" name="tanggal_po">
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Kode Supplier</label>
                                <select class="form-select select-search" id="select-supplier" name="kd_supplier" onchange="updateForm(this)">
                                    <option value="" selected disabled>-- Pilih Supplier --</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->kd_supplier }}" data-supplier="{{ $supplier->name_supplier }}" data-valuta="{{ $supplier->valuta }}">
                                        {{ $supplier->kd_supplier }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" mt-2">
                                <label for="exampleInputName" class="form-label"> </label>
                                <input type="text" class="form-control" id="name_supplier" disabled name="name_supplier">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Status PO</label>
                                <select class="form-select" id="exampleField3" name="status_po">
                                    <option value="Patial">Partial</option>
                                    <option value="Completion">Completion</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tanggal" class="form-label">Jenis Pembelian</label>
                            <select class="form-select" id="exampleField3" name="jenispembelian">
                                <option value="Lokal">Lokal</option>
                                <option value="Import">Import</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Valuta</label>
                                <input type="text" class="form-control" id="valuta" name="valuta" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleInputName" class="form-label">Term</label>
                                <input type="text" class="form-control" id="term" name="term">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal" class="form-label">Tanggal Kirim</label>
                            <input type="date" class="form-control" id="tanggal" value="" placeholder="Masukan Tanggal" name="tanggal_kirim">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputName" class="form-label">Jenis Pembayaran</label>
                                <select class="form-select" id="exampleField3" name="jenispembayaran">
                                    <option value="1">0-1 Bulan</option>
                                    <option value="2">1-6 Bulan</option>
                                    <option value="3">6-12 Bulan</option>
                                    <option value="4">Tunai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input name="id_mr" hidden value="{{$po->id_mr}}" type="text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longText" class="form-label">Keterangan</label>
                                <textarea class="form-control scrollable-textarea" id="longText" name="keterangan"></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Kode Delivery</label>
                                <select class="form-select select-search" id="select-delivery" name="id_delivery" onchange="updateDel(this)">
                                    <option value="" selected disabled>-- Pilih Delivery --</option>
                                    @foreach ($deliverys as $delivery)
                                    <option value="{{ $delivery->id_delivery }}" data-alamat="{{ $delivery->alamat }}">
                                        {{ $delivery->id_delivery }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mt-2">
                                <label for="exampleInputName" class="form-label"></label>
                                <input type="text" class="form-control" id="alamat" name="alamat" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- button back -->
                    <div class="row mb-5">
                        <div class="col-6">
                            <a href="/purchaseorder" class="btn btn-danger btn-md font-weight-bold text-white mt-5">
                                Back
                            </a>
                        </div>
                        <div class="col-6 text-end">
                            <button type="submit" class="btn btn-danger btn-md font-weight-bold text-white mt-5">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function updateForm(sel) {
        var selectedOption = $('#select-supplier').find('option:selected');
        var suppliercode = $('input[name="name_supplier"]');
        var valuta = $('input[name="valuta"]');
        suppliercode.val(selectedOption.data('supplier'));
        valuta.val(selectedOption.data('valuta'));
    }

    function updateDel(select) {
        var selectedOption = $('#select-delivery').find('option:selected');
        var alamat = $('input[name="alamat"]');

        console.log(selectedOption.data('alamat'));
        alamat.val(selectedOption.data('alamat'));
    }
</script>


@endsection