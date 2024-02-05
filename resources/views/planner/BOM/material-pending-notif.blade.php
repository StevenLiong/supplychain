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
        <p>Terdapat material yang kurang pada Bill of Material, berikut informasi detailnya:</p>
        <table class="table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">ID BOM</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">ID Material</th>
                    <th style="width: 15px;border: 1px solid #ddd; text-align: center; ">Nama Material</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Usage Material</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Supplier</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Stock Gudang</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Material Outstanding</th>
                    <th class="bolder" style="border: 1px solid #ddd; padding: 8px; text-align: center; background-color: #00ff00;">ROP Safety</th>
                    <th class="bolder" style="border: 1px solid #ddd; padding: 8px; text-align: center; background-color: #00ff00;">Max Safety</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($material as $item)
                    <!-- Informasi material dari $item -->
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $item['id_boms'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $item['id_materialbom'] }}</td>
                        <td style="width: 15rem; border: 1px solid #ddd; text-align: center;">{{ $item['nama_materialbom'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $item['usage_material'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ isset($stockInfo['supplier']) ? $stockInfo['supplier'] : 'Data tidak ditemukan' }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ isset($materialInfo['jumlah']) ? $materialInfo['jumlah'] : 'Data tidak ditemukan' }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ isset($pesananInfo['qty_pesanan']) ? $pesananInfo['qty_pesanan'] : '0' }}</td>
                        <td class="bolder" style="border: 1px solid #ddd; padding: 8px; text-align: center; background-color: #00ff00;">{{ isset($stockInfo['rop_safety']) ? $stockInfo['rop_safety'] : 'Data tidak ditemukan' }}</td>
                        <td class="bolder" style="border: 1px solid #ddd; padding: 8px; text-align: center; background-color: #00ff00;">{{ isset($stockInfo['max_safety']) ? $stockInfo['max_safety'] : 'Data tidak ditemukan' }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <p class="terima-kasih" style="margin-top: 20px;">Terima kasih,<br><br>Steven Liong</p>
    </div>
</body>

</html>
