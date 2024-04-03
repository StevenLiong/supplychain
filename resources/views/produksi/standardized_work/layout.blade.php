<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$title}} | PT Trafoindo Prima Perkasa</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="https://www.trafoindonesia.com/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/templatetrafindo/assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="/templatetrafindo/assets/css/backend.css?v=1.0.0">
    <link rel="stylesheet"
        href="/templatetrafindo/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/remixicon/fonts/remixicon.css">

    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">

    <!-- icon  -->
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="path/to/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .wrapper {
            min-height: 100vh;
            margin-bottom: 60px;
            /* Sesuaikan dengan tinggi footer */
            box-sizing: border-box;
        }

        .content {
            /* Gaya untuk konten utama */
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        footer {
            /* Gaya untuk footer */
            background-color: #cb0606;
            color: #fff;
            padding: 10px;
        }
        label {
            font-weight: bold;
        }

        .col-lg-6 {
            padding: 2;
        }

        td {
            padding-left: 5px;
            padding-right: 5px;
        }

        tr {
            padding-bottom: 0px;
        }

        .label {
            margin-bottom: 0px;
        }

        /* Perubahan pada bagian .select2.select2-container .select2-selection--multiple */
        .select2.select2-container .select2-selection--multiple {
            min-height: 34px;
            height: auto !important;
        }

        /* Perubahan pada bagian .select2.select2-container .select2-selection--multiple .select2-selection__rendered */
        .select2.select2-container .select2-selection--multiple .select2-selection__rendered {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 4px;
        }

        /* Menambahkan gaya pada button silang */
        .select2.select2-container .select2-selection--multiple .select2-selection__choice__remove {
            margin-left: 4px;
            font-size: 20px;
            cursor: pointer;

            /* Latar belakang awal */
            border: 1px solid transparent;
            /* Tambahkan border */
            color: #ee1818;

            /* Warna ikon */
            border-radius: 4px;
            /* Bentuk kotak */
            /* transition: background-color 0.3s, color 0.3s, border-color 0.3s; */
            /* Efek transisi */
        }

        /* Ubah warna latar belakang ketika dihover */
        /* .select2.select2-container .select2-selection--multiple .select2-selection__choice__remove:hover {
                background-color: #ee1818;

                color: white;

                border-color: #ee1818;

            } */
        /* Merubah style dari tombol clear */
        .select2-selection__clear {
            color: red;
            font-size: 16px;
        }

        /* Merubah style dari tombol clear saat dihover */
        .select2-selection__clear:hover {
            color: darkred;
            cursor: pointer;
        }

        /* Perubahan ukuran isian saat diisi */
        .select2.select2-container .select2-selection--multiple .select2-search__field {
            margin-top: 0;
            height: 32px;
            /* Tinggi isian */
            font-size: 14px;
            /* Ukuran font */
            line-height: 30px;
            /* Line height */
            padding: 1px 6px;
            /* Padding */
        }
    </style>
</head>


<body class=" color-light ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper ">
        <!-- <div class="content-page"> -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div id="app"   >
                        <!-- - - - - - - - - - - - start content-- - - - - - - - - - - -->
                        @yield('content')
                        <!-- - - - - - - - - - - - end content-- - - - - - - - - - - -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 text-left     text-primary">
                    <span class="mr-1"> Supply Chain Team </span>
                </div>
                <div class="col-lg-6 text-right text-primary">
                    <span class="mr-1">
                        <script>
                            document.write(new Date().getFullYear())
                        </script>©
                    </span> <a href="#" class="">MSIB TRAFINDO BATCH 5 1</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Backend Bundle JavaScript -->
    <script src="/templatetrafindo/assets/js/backend-bundle.min.js"></script>

    <!-- Table Treeview JavaScript -->
    <script src="/templatetrafindo/assets/js/table-treeview.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="/templatetrafindo/assets/js/customizer.js"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="/templatetrafindo/assets/js/chart-custom.js"></script>
    <!-- Chart Custom JavaScript -->
    <script async src="/templatetrafindo/assets/js/slider.js"></script>

    <!-- app JavaScript -->
    <script src="/templatetrafindo/assets/js/app.js"></script>

    <script src="/templatetrafindo/assets/vendor/moment.min.js"></script>
</body>

</html>
