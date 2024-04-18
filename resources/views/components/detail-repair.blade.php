<div class="row ">
    <div class="col-md-12 m-0 ">
        <div class="card rounded m-0" style="border-left-color: red; border-left-width: 10px;">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-lg-2 col-sm-6">
                        <h6>Total Hour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-total_hour">
                            <b>
                                    {{ $detail->repair->total_hour }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Category</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-category">
                            <b>
                                {{ $detail->repair->nama_product }} </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kapasitas</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas">
                            <b>
                                {{ $detail->repair->ukuran_kapasitas }} </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>SO/No.Proyek</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                {{ $detail->repair->nomor_so }} </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kode Manhour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                {{ $detail->repair->kd_manhour }} </b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
