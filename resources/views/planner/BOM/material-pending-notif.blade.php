<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100px;
            height: auto;
        }

        .greeting {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .content {
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="container">
      <div class="header">
        <img src="/templatetrafindo/assets/images/logotrafindo.png" style="width: 10rem;height:5rem;" alt="logo_trafoindo">
      </div>

        <div class="greeting">
            <p>Dear PPIC Departemen Planner PT. Trafoindo Prima Perkasa,</p>
        </div>
        <div class="content">
            <!-- Isi konten email Anda di sini -->
            <p>Terdapat material yang kurang, berikut informasi detail nya:</p>
            <p>ID BOM: {{ $idBom }}</p>
            <p>ID Material: {{$idMaterial}}</p>
        </div>
        <div class="footer">
            <p>Terima kasih,<br>Steven Liong</p>
        </div>
    </div>
</body>
</html>