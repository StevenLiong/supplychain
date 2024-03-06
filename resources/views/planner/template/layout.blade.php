<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{}} || Resource Work Planing</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="https://www.trafoindonesia.com/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/templatetrafindo/assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="/templatetrafindo/assets/css/backend.css?v=1.0.0">
    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/remixicon/fonts/remixicon.css">

    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="/templatetrafindo/assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">

    <!-- icon  -->
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="path/to/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    @yield('style')

</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

        <!-- sidebar & navbar  -->
        @yield('sidebar')
        @yield('navbar')


        <!-- start content  -->
        <div class="content-page px-4">
            <div class="container-fluid ">
                <div class="row" style="display: unset;">
                   
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- end content  -->
    </div>
    <!-- Wrapper End-->


    <!-- footer -->
    @yield('footer')

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

    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

@yield('script')

</body>

</html>