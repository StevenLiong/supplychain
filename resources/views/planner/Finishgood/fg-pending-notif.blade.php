<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Planner</title>
    <style>
        body {
            background-color: #bdc3c7;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            margin: 10% auto;
            width: 580px;
            max-width: 580px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        .header-logo img {
            width: 10rem;
            height: 5rem;
        }

        .garis {
            width: 75%;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .terima-kasih {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="card" style="background-color: #fff; padding: 20px; margin: 10% auto; width: 580px; max-width: 580px; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);">

        <h2>Dear PPIC Departemen Planner PT. Trafoindo Prima Perkasa,</h2>
        <hr class="garis" style="width: 75%; margin-top: 10px; margin-bottom: 20px; border: 1px solid #ccc;">
        <p>Terdapat Finish Good yang sudah harus di produksi kembali, berikut informasi detailnya:</p>
        <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class="ligth" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 6rem; text-align: center" rowspan="2" class="text-center align-middle">Kode Finish Good</th>
                                <th style="width: 6rem; text-align: center" rowspan="2" class="text-center align-middle">Nama Item</th>
                                <th style="width: 6rem; text-align:center" rowspan="2" class="text-center align-middle">Max Kanban</th>
                                <th style="width: 6rem; text-align:center" rowspan="2" class="text-center align-middle">Stock On Hand</th>
                                <th style="width: 6rem; text-align:center" rowspan="2" class="text-center align-middle">Peruntukan Unit</th>
                                <th style="width: 6rem; text-align:center" rowspan="2" class="text-center align-middle">Stock Akhir</th>
                                <th style="width: 18rem; text-align:center;" colspan="3" class="text-center align-middle">ORDER REQUEST</th>

                            </tr>
                            <tr class="ligth" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 6rem; text-align:center;" class="text-center align-middle">Unit</th>
                                <th style="width: 6rem; text-align:center;" class="text-center align-middle">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($kanbanfg as $item)
                          <tr role="row" class="odd">
                              <td style="width: 6rem; text-align: center">{{ $item['kode_fg'] }}</td>
                              <td style="width: 6rem; text-align: center">{{ $item['nama_item'] }}</td>
                              <td style="width: 6rem; text-align: center">{{ $item['max_kanban'] }}</td>
                              <td style="width: 6rem; text-align: center">{{ $item['stock_on_hand'] }}</td>
                              <td style="width: 6rem; text-align: center">{{ $item['peruntukan_unit'] }}</td>
                              <td style="width: 6rem; text-align: center">{{ $item['stock_akhir'] }}</td>
                              <td style="width: 6rem; text-align: center;">{{ $item['unit'] }}</td>
                              <td style="width: 6rem; text-align: center; background-color: #00ff00;">{{ $item['status'] }}</td>
                          </tr>
                      @endforeach

                        </tbody>
                    </table>
        <p class="terima-kasih" style="margin-top: 20px;">Terima kasih,<br></p>
    </div>
</body>

</html>
