@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            <div class="row col-lg-12 justify-content-center mt-3 ">
                <div class="col-lg-6 col-sm-12 ">
                    <div class="card p-3 rounded-0 justify-content-center">

                        <div class="card-title text-center border-bottom">
                            <h3>Picking Material</h3>
                        </div>

                        {{-- search --}}
                        <div class="row justify-content-center">
                            <div class="m-3 col-lg-8">
                                <form id="searchForm" onsubmit="return searchMaterial()">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm rounded-0"
                                            placeholder="cari material..." name="search" value="{{ request('search') }}">
                                        <button class="btn btn-red rounded-0 btn-xs" type="submit">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- search end --}}
                        <div id="searchResults" class="row justify-content-center">
                            {{-- table data --}}
                            @if (isset($_GET['search']) && !empty($_GET['search']))
                                <div class="table-responsive col-lg-8">
                                    @if ($materialRak->isNotEmpty())
                                        <table class="table table-sm table-bordered table-hover">
                                            <thead class="table-secondary">
                                                <tr class="text-center">
                                                    <th>Kode Rak</th>
                                                    <th>Kode Material</th>
                                                    <th>Nama Material</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($materialRak as $key => $item)
                                                    <tr>
                                                        <td>{{ $item->rak->kd_rak }}</td>
                                                        <td>{{ $item->material->kd_material }}</td>
                                                        <td>{{ $item->material->nama_material }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-center">Tidak ada data</p>
                                    @endif
                                </div>
                            @endif
                            {{-- table data end --}}
                        </div>

                        {{-- Scan --}}
                        <div class="row justify-content-center border-top">
                            <div class="col-lg-12 text-center">
                                <p>Scan rak untuk mengambil material dari rak</p>
                            </div>
                            <div class="col-lg-12 text-center">
                                <!-- Button trigger modal -->
                                <button type="button" id="scanModal" class="btn btn-red btn-xs" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Scan Rak
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Scan Rak</h1>
                                                <button type="button" id="closeScan" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="scan m-3">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-12 col-sm-12">
                                                            <div class="card p-3 rounded-0">
                                                                <video id="preview"></video>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Scan end --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        // search
        function activateScanner() {
            let scanner = new Instascan.Scanner({
                video: document.getElementById('preview')
            });
            scanner.addListener('scan', function(content) {
                console.log(content);
                let id = content;
                window.location.href = '/services/transaksigudang/picking/cutstock/' + id;
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
        }

        function deactivateScanner() {
            console.log("Deactivating scanner");
                scanner.stop()
        }
        // event ketika modal di tampilkan
        var scan = document.getElementById('exampleModal');
        var closeModal = document.getElementById('closeScan')

        // Event listener when the modal is about to be shown
        scan.addEventListener('show.bs.modal', function() {
            activateScanner();
        });

        // Event listener when the modal is hidden
        scan.addEventListener('hidden.bs.modal', function() {
            deactivateScanner();
        });

        closeModal.addEventListener('click', function() {
            scanner.start(cameras[0]);
        });
    </script>
@endsection
