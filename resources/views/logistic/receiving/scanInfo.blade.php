@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            <div class="scan m-3">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-sm-12">
                        <div class="card p-3 rounded-0">
                            <video id="preview"></video>
                        </div>
                        <!-- Button find material  modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Find Material code
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Stock In</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Input code"
                                                aria-label="Input code" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">Search</span>
                                        </div>

                                        <div class="card p-3 rounded-0">
                                            <form action="" method="post">
                                                <div class="mb-3">
                                                    <label for="nama_material">Nama Material</label>
                                                    <input type="text" class="form-control" name="nama_material"
                                                        id="nama_material">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="input_stock">Jumlah masuk</label>
                                                    <input type="text" class="form-control" name="input_stock">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        scanner.addListener('scan', function(content) {
            console.log(content);
        });
        scanner.addListener('scan', function(content) {
            let id = content;

            window.location.href = '/receiving/incoming/' +id;
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });
    </script>
@endsection
