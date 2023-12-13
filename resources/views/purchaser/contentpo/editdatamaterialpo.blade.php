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
                <form action="/purchaseorder/editPo/{{ $po->id_po}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nomer PO</label>
                                <input type="text" class="form-control" id="exampleField1" value="{{$po->id_po}}" name="id_po" readonly>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" value="{{$po->tanggal_po}}" placeholder="Masukan Tanggal" name="tanggal_po" readonly>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Kode Supplier</label>
                                <input value="{{ $po->kd_supplier}}" class="form-control" name="kd_supplier" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" mt-2">
                                <label for="exampleInputName" class="form-label"> </label>
                                <input value="{{ $po->supplier->nama_supplier}}" class="form-control" name="nama_supplier" disabled>
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
                            <input value="{{ $po->jenispembelian}}" class="form-control" name="jenispembelian" disabled>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Valuta</label>
                                <input type="text" class="form-control" id="valuta" name="valuta" value="{{ $po->Supplier->valuta }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleInputName" class="form-label">Term</label>
                                <input type="text" class="form-control" id="term" name="term" value="{{ $po->term}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal" class="form-label">Tanggal Kirim</label>
                            <input type="date" class="form-control" id="tanggal" value="{{ $po->tanggal_kirim}}" placeholder="Masukan Tanggal" name="tanggal_kirim" disabled>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputName" class="form-label">Jenis Pembayaran</label>
                                <input type="text" class="form-control" id="exampleField3" name="jenispembayaran" value="{{ $po->jenispembayaran }}" disabled>
                            </div>
                        </div>
                    </div>
                    <input name="id_mr" hidden value="{{$po->id_mr}}" type="text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longText" class="form-label">Keterangan</label>
                                <textarea class="form-control scrollable-textarea" id="longText" name="keterangan">{{$po->keterangan}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Kode Delivery</label>
                                <input type="text" class="form-control" name="id_delivery" value="{{ $po->id_delivery }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mt-2">
                                <label for="exampleInputName" class="form-label"></label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $po->delivery->alamat }}" disabled>
                            </div>
                        </div>
                    </div>
                    <thead>
                        <tr>
                            <h3 class="text-dark my-2 text-center mt-5">List Material Request</h3>
                        </tr>
                        <br>
                    </thead>
                    <table class="table-bordered table">
                        <thead class="table-light text-center">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode Material</th>
                                <th scope="col">Nama Material</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($po->mr->pesanan as $nomer => $pesanan)
                            <tr>
                                <td class="table-plus">{{ $nomer + 1 }}</td>
                                <td class="table-plus">{{ $pesanan->kd_material }}</td>
                                <input type="hidden" value="{{ $pesanan->id_pesanan}}" name="pesanan[]">
                                <td class="table-plus">{{ $pesanan->material->nama_material }}</td>
                                <td class="table-plus">{{ $pesanan->qty_pesanan }}</td>
                                <td> <input class="table-plus" contenteditable="true" value="{{ $pesanan->total }}" name="total[]"></td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

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


<!-- script editcell -->
<script>
    function saveCellValue(cell) {
        // Fungsi ini akan dipanggil saat user selesai mengedit dan pindah dari cell
        // Di sini Anda bisa menambahkan logika untuk menyimpan nilai ke dalam database atau melakukan tindakan lainnya.

        let newValue = cell.innerText;
        // Anda bisa menambahkan logika untuk menyimpan nilai ke dalam database atau melakukan tindakan lainnya.
        // Contoh:
        // Simpan nilai ke database dengan AJAX atau metode lainnya
        // fetch('url_simpan_data', {
        //     method: 'POST',
        //     body: JSON.stringify({ newValue }),
        //     headers: {
        //         'Content-Type': 'application/json'
        //     }
        // })
        // .then(response => {
        //     // Tindakan setelah nilai disimpan
        // })
        // .catch(error => {
        //     // Tangani kesalahan jika ada
        // });
    }
</script>

<!-- <script>
    function updateForm(sel) {
        var selectedOption = $('#select-supplier').find('option:selected');
        var suppliername = $('input[name="supplier"]');
        var valuta = $('input[name="valuta"]');
        suppliername.val(selectedOption.data('supplier'));
        valuta.val(selectedOption.data('valuta'));
    }

    function updateDel(select) {
        var selectedOption = $('#select-delivery').find('option:selected');
        var alamat = $('input[name="alamat"]');

        console.log(selectedOption.data('alamat'));
        alamat.val(selectedOption.data('alamat'));
    }
</script> -->


@endsection