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

            window.location.href = '/datamaster/material/addstock/' + id;
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
