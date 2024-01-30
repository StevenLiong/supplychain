@extends('purchaser.layout.layoutmr.wraplayoutmr')

@section('title', 'materialrequest')
@section('contentmr')

<div>
    <div>
        <div style="background-color: white;">
            <!-- lOGO TRAFOINDO -->
            <div class="container d-flex justify-content-center align-items-center">
                <img src="/Assets/LogoTrafoindo.png" alt="Centered Image" style="width: 235px;">
            </div>
            <!--  -->
            <!-- form salesorder -->
            <div>
                <form action="/materialrequest/{{$mr->id_mr}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-5"></div> <!-- div kosong -->
                        <div class="col-md-5"></div> <!-- div kosong -->
                        <div class="col-md-2">
                            <div style="position: relative; right: 14px;" class="mt-2">
                                <label for="exampleInputName" class="form-label">Status</label>
                                <select class="form-select" id="exampleField3" name="status_mr">
                                    <option value="Hold">Hold</option>
                                    <option value="Slip">Slip</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="mb-3">
                            <label for="id_mr" class="form-label">PR NO</label>
                            <input type="text" class="form-control" id="id_mr" placeholder="Masukan id MR" value="{{$mr->id_mr}}" name="id_mr" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Date</label>
                            <input type="date" class="form-control" id="tanggal" value="{{$mr->tanggal_mr}}" placeholder="Masukan Tanggal" name="tanggal_mr" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Division Name</label>
                            <input value="{{ $mr->division->name_division }}" class="form-control" name="division" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Division Code</label>
                            <input type="text" class="form-control" name="id_division" value="{{ $mr->id_division }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" value="" rows="3" name="keterangan">{{$mr->keterangan}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Accepted date</label>
                            <input disabled type="date" class="form-control" id="tanggal" value="{{$mr->accepted_mr}}" placeholder="Masukan Tanggal" name="accepted_mr">
                        </div>

                        <div class=" mt-5 items">
                            <h3 class="my-1 text-muted text-center">List Barang</h3>
                            @foreach($mr->pesanan as $pesanan)
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Kode Material</label>
                                <div class="row d-flex justify-content-between">
                                    <div class="col-8">
                                        <input readonly type="text" class="form-control " id="tanggal" value="{{$pesanan->material->kd_material}}" name="">
                                    </div>
                                    <div class="col">
                                        <strong>qty</strong>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" name="" value="{{$pesanan->qty_pesanan}}">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" name="" value="{{$pesanan->material->satuan}}" disabled>
                                    </div>
                                    <div class="col">
                                        <a class=" btn btn-danger form-control" href="/materialrequest/delete/{{$pesanan->id_pesanan}}"><i class="bi bi-trash-fill"></i></a>
                                    </div>
                                    <div class="mb-3 mt-4">
                                        <label for="exampleFormControlInput1" class="form-label">Nama Material</label>
                                        <input type="text" class="form-control nama_material" id='nama_material' value="{{$pesanan->material->nama_material}}" name="nama_material" disabled>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <h3 class="my-1 text-muted text-center">Add Material</h3>
                            <div class="item mt-4">
                                <div>
                                    <label for="exampleFormControlInput1" class="form-label">Kode Material</label>
                                </div>
                                <div class="row d-flex justify-content-between">
                                    <div class="col-8">
                                        <select class="form-select material-select" placeholder="Enter Customer Name" id="material" name="material[]" onchange="updateMaterial(this)">
                                            <option value="" selected disabled>-- Pilih Material --</option>
                                            @foreach ($materials as $material)
                                            <option value="{{ $material->kd_material }}" data-nama="{{$material->nama_material}}" data-dim="{{$material->satuan}}">{{ $material->kd_material }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <strong>qty</strong>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" name="qty[]" value="0">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" id="satuan" name="satuan" disabled>
                                    </div>
                                    <div class="col">
                                        <div class=" btn btn-danger form-control " onclick="deleteItem(this)"><i class="bi bi-trash-fill"></i>
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-4">
                                        <label for="exampleFormControlInput1" class="form-label">Nama Material</label>
                                        <input type="text" class="form-control nama_material" id='nama_material' name="nama_material" disabled>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center my-3 mb-3">
                            <div onclick="addNewItem()" class="btn btn-secondary btn-sm">Add Items</div>
                        </div>
                </form>

                <!-- button back -->
                <div class="row mb-5">
                    <div class="col-6">
                        <a href="\materialrequest" class="btn btn-danger btn-md font-weight-bold text-white mt-5">
                            Back
                        </a>
                    </div>
                    <div class="col-6 text-end">
                        <button type="submit" class="btn btn-danger btn-md font-weight-bold text-white mt-5">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- adddivision script -->
<script>
    function updateForm(sel) {
        var selectedOption = $('#select-division').find('option:selected');
        var divisioncode = $('input[name="id_division"]');

        divisioncode.val(selectedOption.data('division'));
    }

    function updateMaterial(select) {
        var selectedOption = $(select).find(":selected");
        var dimension = $(select).closest(".item").find('input[name="satuan"]');
        var name = $(select).closest(".item").find('input[name="nama_material"]');

        var dataDim = selectedOption.data("dim");
        var dataName = selectedOption.data("nama");
        dimension.val(dataDim);
        name.val(dataName);
    }

    //variabel kosong, harus sama dengan var pada script
    function updateItem(select) {
        var selectedOption = $(select).find(":selected");
        var dimension = $(select).closest(".item").find('input[name="dim"]');
        var quantity = $(select).closest(".item").find('input[name="qty[]"]');

        var dataDim = selectedOption.data("dim");
        var dataMax = selectedOption.data("qty");
        dimension.val(dataDim);
        quantity.attr('max', dataMax);
    }
</script>



<!-- addmaterial script -->
<!-- <script>
    let itemCount = 1;

    
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('material-select')) {
            const material = event.target.value;

           
            const specificationSelect = event.target.parentElement.parentElement.parentElement.querySelector(
                '.specification-select');


            specificationSelect.innerHTML = '';
            const temp = document.createElement('option');
            temp.value = '';
            temp.text = '-- Pilih Spesifikasi --';
            specificationSelect.appendChild(temp);

            if (material) {
               
                $.ajax({
                    url: '/get/material/' + material,
                    type: 'GET',
                    success: function(data) {
                        
                        data.forEach(function(stock) {
                            const option = document.createElement('option');
                            
                            option.value = stock.id_material;
                            option.text = stock.spesifikasi;

                            option.setAttribute('data-dim', '');
                            option.setAttribute('data-qty', '');
                            specificationSelect.appendChild(option);
                        });
                    }
                });
            }
        }
    });

    
</script> -->
<script>
    let itemCount = 1;
    function addNewItem() {
        itemCount++;
        const formContainer = document.querySelector(".items");
        const originalDiv = formContainer.querySelector(".item");
        const newDiv = originalDiv.cloneNode(true);

        // Update IDs and names for the new elements
        // newDiv.querySelectorAll('.material-select').forEach((select) => {
        // select.id = `material${itemCount}`;
        // select.name = `category`;
        // });

        newDiv.querySelector('.nama_material').innerHTML = '';

        formContainer.appendChild(newDiv);
    }

    function deleteItem(element) {
        const itemElements = document.querySelectorAll('.item');
        if (itemElements.length > 1) {
            element.parentElement.parentElement.parentElement.remove();
        };

    }
</script>

{{-- <script>
    $(document).ready(function() {
        var url = window.location.href;
        var parts = url.split('/');
        var storeId = parts[parts.length - 1];
        $('#material').on('change', function() {
            var materialId = $(this).val();
            var stockDropdown = $('#stock');
            
            // Clear existing options
                    stockDropdown.empty();
                    
                    if (materialId) {
                        // Fetch stocks based on the selected material and current store using an AJAX request
                        $.ajax({
                            url: '/get/stock/' + materialId + '/' + storeId,
                            type: 'GET',
                            success: function(data) {
                                // Populate the stock dropdown with the retrieved data
                                $.each(data, function(index, stock) {
                                    stockDropdown.append('<option value="' + stock.id_stock +
                                    '">' + stock.spesifikasi_sparepart + '</option>');
                                });
                            }
                        });
                    }
                });
            });
        </script> --}}
<!-- <script>
    let itemCount = 1;

function addNewItem() {
    const formContainer = document.querySelector(".items");
    const originalDiv = formContainer.querySelector(".item");
    const newDiv = originalDiv.cloneNode(true);

    
    newDiv.querySelector('select.material-select').selectedIndex = 0;
    newDiv.querySelector('input[name="qty[]"]').value = "0";
    newDiv.querySelector('input[name="satuan"]').value = "";
    newDiv.querySelector('.nama_material').value = "";

    formContainer.appendChild(newDiv);
}

function deleteItem(element) {
    const itemElements = document.querySelectorAll('.item');
    if (itemElements.length > 1) {
        element.closest('.item').remove();
    }
}
</script> -->

@endsection