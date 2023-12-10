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
        <p>Terdapat material yang kurang, berikut informasi detailnya:</p>
        <table class="table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ID BOM</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ID Material BOM</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nama Material</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Usage Material</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Supplier</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Stock Gudang</th>
                    <th class="bolder" style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #00ff00;">ROP Safety</th>
                    <th class="bolder" style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #00ff00;">Max Safety</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($material as $item)
                    <!-- Informasi material dari $item -->
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $item['id_boms'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $item['id_materialbom'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $item['nama_materialbom'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $item['usage_material'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $stockInfo->supplier }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $materialInfo['jumlah'] }}</td>
                        <td class="bolder" style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #00ff00;">{{ $stockInfo->rop_safety }}</td>
                        <td class="bolder" style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #00ff00;">{{ $stockInfo->max_safety }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <p class="terima-kasih" style="margin-top: 20px;">Terima kasih,<br><br>Steven Liong</p>
    </div>
</body>

</html>
