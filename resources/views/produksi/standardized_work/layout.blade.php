
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>$title | PT Trafoindo Prima Perkasa</title>

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

</head>


<body class=" color-light ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- <div class="content-page"> -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <!-- - - - - - - - - - - - start content-- - - - - - - - - - - -->
                    @yield('content')
                    <!-- - - - - - - - - - - - end content-- - - - - - - - - - - -->
                </div>
            </div>
        </div>
    </div>
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="../backend/privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="../backend/terms-of-service.html">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                    <span class="mr-1">
                        <script>
                            document.write(new Date().getFullYear())
                        </script>©
                    </span> <a href="#" class="">Webkit</a>.
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
            var filteredData = data.filter(function(item) {
                return (
                    item.nama_kategoriproduk === 'DRY TYPE RESIN' &&
                    item.nama_workcenter === selectedWorkcenter &&
                    item.nama_proses === selectedProses
                );
            });
            $(elementId).empty();
            $(elementId).append('<option value="">-Pilih-</option>');
            $.each(filteredData, function(key, data) {
                $(elementId).append(
                    '<option value="' + data.nama_tipeproses + '" data-durasi="' + data
                    .durasi_manhour +
                    '" data-workcenter="' + data.nama_workcenter + '">' +
                    data.nama_tipeproses +
                    '</option>'
                );
            });
        }
        $('#ukuran_kapasitas').on('change', function() {
            var ukuran_kapasitas = $(this).val();
            console.log(ukuran_kapasitas);
            if (ukuran_kapasitas) {
                $.ajax({
                    url: '/standardized_work/Create-Data/Dry-Cast-Resin/kapasitas/' + ukuran_kapasitas,
                    type: 'GET',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            fillSelect('#coil_lv', data, 'COIL LV', 'COIL MAKING');
                            fillSelect('#coil_hv', data, 'COIL HV', 'COIL MAKING');
                            fillSelect('#potong_leadwire', data, 'POTONG LEAD WIRE',
                                'COIL MAKING');
                            fillSelect('#potong_isolasi', data, 'POTONG ISOLASI',
                                'COIL MAKING');
                            fillSelect('#hv_moulding', data, 'HV MOULDING',
                                'MOULD & CASTING');
                            fillSelect('#hv_casting', data, 'HV CASTING',
                                'MOULD & CASTING');
                            fillSelect('#hv_demoulding', data, 'HV DEMOULDING',
                                'MOULD & CASTING');
                            fillSelect('#lv_bobbin', data, 'LV BOBBIN',
                                'MOULD & CASTING');
                            fillSelect('#lv_moulding', data, 'LV MOULDING',
                                'MOULD & CASTING');
                            fillSelect('#touch_up', data, 'TOUCH UP',
                                'MOULD & CASTING');
                            fillSelect('#type_susun_core', data, 'TYPE SUSUN CORE',
                                'CORE COIL ASSEMBLY');
                            fillSelect('#wiring', data, 'WIRING', 'CORE COIL ASSEMBLY');
                            fillSelect('#instal_housing', data, 'INSTAL HOUSING',
                                'CORE COIL ASSEMBLY');
                            fillSelect('#bongkar_housing', data, 'BONGKAR HOUSING',
                                'CORE COIL ASSEMBLY');
                            fillSelect('#pembuatan_cu_link', data, 'PEMBUATAN CU LINK',
                                'CORE COIL ASSEMBLY');
                            fillSelect('#others', data, 'OTHERS', 'CORE COIL ASSEMBLY');
                            fillSelect('#accesories', data, 'ACCESORIES',
                                'CORE COIL ASSEMBLY');
                            fillSelect('#potong_isolasi_fiber', data,
                                'POTONG ISOLASI FIBER', 'CORE COIL ASSEMBLY');
                            fillSelect('#routine_test', data, 'ROUNTINE',
                                'QC TESTv');
                            $('#coil_lv').on('change', function() {
                                showSelected('coil_lv');
                            });
                            $('#coil_hv').on('change', function() {
                                showSelected('coil_hv');
                            });
                            $('#potong_leadwire').on('change', function() {
                                showSelected('potong_leadwire');
                            });
                            $('#potong_isolasi').on('change', function() {
                                showSelected('potong_isolasi');
                            });
                            $('#hv_moulding').on('change', function() {
                                showSelected('hv_moulding');
                            });
                            $('#hv_casting').on('change', function() {
                                showSelected('hv_casting');
                            });
                            $('#hv_demoulding').on('change', function() {
                                showSelected('hv_demoulding');
                            });
                            $('#lv_bobbin').on('change', function() {
                                showSelected('lv_bobbin');
                            });
                            $('#lv_moulding').on('change', function() {
                                showSelected('lv_moulding');
                            });
                            $('#touch_up').on('change', function() {
                                showSelected('touch_up');
                            });
                            $('#type_susun_core').on('change', function() {
                                showSelected('type_susun_core');
                            });
                            $('#wiring').on('change', function() {
                                showSelected('wiring');
                            });
                            $('#instal_housing').on('change', function() {
                                showSelected('instal_housing');
                            });
                            $('#bongkar_housing').on('change', function() {
                                showSelected('bongkar_housing');
                            });
                            $('#pembuatan_cu_link').on('change', function() {
                                showSelected('pembuatan_cu_link');
                            });
                            $('#others').on('change', function() {
                                showSelected('others');
                            });
                            $('#accesories').on('change', function() {
                                showSelected('accesories');
                            });
                            $('#potong_isolasi_fiber').on('change', function() {
                                showSelected('potong_isolasi_fiber');
                            });
                            $('#routine_test').on('change', function() {
                                showSelected('routine_test');
                            });
                        } else {
                            resetForm();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Request Error:', xhr.responseText);
                        alert(
                            'Terjadi kesalahan saat mengambil data barang. Silakan coba lagi.'
                        );
                    }
                });
            } else {
                resetForm();
            }
        });
    });

    function showSelected(target) {
        let selectElements = document.querySelectorAll('select');
        let totalManhour = 0;
        selectElements.forEach(function(select) {
            let selectedOptions = Array.from(select.selectedOptions);
            selectedOptions.forEach(function(selectedOption) {
                let durasi = selectedOption.getAttribute('data-durasi');
                totalManhour += parseFloat(durasi || 0);
            });
        });
        let totalHourInput = document.getElementById('total_hour');
        totalHourInput.value = totalManhour;
        let select = document.getElementById(target);
        console.log('Select Element:', select);
        let selectedOptions = Array.from(select.selectedOptions);
        let totalDurasi = 0;
        selectedOptions.forEach(function(selectedOption) {
            let selectedDurasi = selectedOption.getAttribute('data-durasi');
            totalDurasi += parseFloat(selectedDurasi || 0);
        });
        let selectedInfo = document.getElementById("selectedInfo_" + target);
        console.log('Selected Info Element:', selectedInfo);
        selectedInfo.textContent = " " + totalDurasi;
        console.log(selectedInfo);
        console.log(totalDurasi);
    }

    function displayTotalJamCoilMaking() {
        let selectElements = document.querySelectorAll('select');
        let totalJam = 0;
        let workcenterInfo = {};
        selectElements.forEach(function(select) {
            let selectedOptions = Array.from(select.selectedOptions);
            selectedOptions.forEach(function(selectedOption) {
                let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                if (workCenterAttr === 'COIL MAKING') {
                    totalJam += durasi;
                    if (!workcenterInfo[workCenterAttr]) {
                        workcenterInfo[workCenterAttr] = durasi;
                    } else {
                        workcenterInfo[workCenterAttr] += durasi;
                    }
                }
            });
        });
        console.log("Work Center (COIL MAKING):", workcenterInfo);
        let totalJamElement = document.getElementById("totalJam_value");
        if (totalJamElement) {
            totalJamElement.textContent = totalJam;
        }
    }

    function displayTotalJamMouldCasting() {
        let selectElements = document.querySelectorAll('select');
        let totalJam = 0;
        let workcenterInfo = {};
        selectElements.forEach(function(select) {
            let selectedOptions = Array.from(select.selectedOptions);
            selectedOptions.forEach(function(selectedOption) {
                let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                if (workCenterAttr === 'MOULD & CASTING') {
                    totalJam += durasi;
                    if (!workcenterInfo[workCenterAttr]) {
                        workcenterInfo[workCenterAttr] = durasi;
                    } else {
                        workcenterInfo[workCenterAttr] += durasi;
                    }
                }
            });
        });
        console.log("Work Center (MOULD & CASTING):", workcenterInfo);
        let totalJamElement = document.getElementById("totalMouldCasting_value");
        if (totalJamElement) {
            totalJamElement.textContent = totalJam;
        }
    }

    function displayTotalJamCoreCoilAssembly() {
        let selectElements = document.querySelectorAll('select');
        let totalJam = 0;
        let workcenterInfo = {};
        selectElements.forEach(function(select) {
            let selectedOptions = Array.from(select.selectedOptions);
            selectedOptions.forEach(function(selectedOption) {
                let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                if (workCenterAttr === 'CORE COIL ASSEMBLY') {
                    totalJam += durasi;
                    if (!workcenterInfo[workCenterAttr]) {
                        workcenterInfo[workCenterAttr] = durasi;
                    } else {
                        workcenterInfo[workCenterAttr] += durasi;
                    }
                }
            });
        });
        console.log("Work Center (CORE COIL ASSEMBLY):", workcenterInfo);
        let totalJamElement = document.getElementById("totalCoreCoilAssembly_value");
        if (totalJamElement) {
            totalJamElement.textContent = totalJam;
        }
    }

    function displayTotalJamQCTest() {
        let selectElements = document.querySelectorAll('select');
        let totalJam = 0;
        let workcenterInfo = {};
        selectElements.forEach(function(select) {
            let selectedOptions = Array.from(select.selectedOptions);
            selectedOptions.forEach(function(selectedOption) {
                let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                if (workCenterAttr === 'QC TEST') {
                    totalJam += durasi;
                    if (!workcenterInfo[workCenterAttr]) {
                        workcenterInfo[workCenterAttr] = durasi;
                    } else {
                        workcenterInfo[workCenterAttr] += durasi;
                    }
                }
            });
        });
        console.log("Work Center (QC TEST):", workcenterInfo);
        let totalJamElement = document.getElementById("totalQCTest_value");
        if (totalJamElement) {
            totalJamElement.textContent = totalJam;
        }
    }
    document.querySelectorAll('select').forEach(function(select) {
        select.addEventListener('change', function() {
            let selectedOption = select.options[select.selectedIndex];
            let workCenter = selectedOption.getAttribute('data-workcenter');
            if (workCenter === 'COIL MAKING') {
                displayTotalJamCoilMaking();
            } else if (workCenter === 'MOULD & CASTING') {
                displayTotalJamMouldCasting();
            } else if (workCenter === 'CORE COIL ASSEMBLY') {
                displayTotalJamCoreCoilAssembly();
            } else if (workCenter === 'QC TEST') {
                displayTotalJamQCTest();
            }
        });
    });
</script>
</body>

</html>
