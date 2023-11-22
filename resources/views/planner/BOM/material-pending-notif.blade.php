<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Planner</title>
    <style>
        body {
            background-color:#bdc3c7;
            margin:0;
        }
        .card {
            background-color:#fff;
            padding:20px;
            margin:20%;
            text-align:center;
            margin:0px auto;
            width: 580px; 
            max-width: 580px;
            margin-top:10%;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        .garis {
            width: 75%;
        }
        
    </style>
</head>
<body>
    <div class="card">
        <a class="header-logo">
            <img src="public/templatetrafindo/assets/images/logotrafindo.png" style="width: 10rem;height:5rem;" alt="logo_trafoindo">
        </a>

        <p>Dear PPIC Departemen Planner PT. Trafoindo Prima Perkasa,</p>
        <hr class="garis">
        <p>Terdapat material yang kurang, berikut informasi detail nya:</p>
        <ul>
            @foreach($notifMaterial as $notifMaterial)
                <li>ID Material BOM: {{ $notifMaterial->id_materialbom }}</li>
                <li>ID BOM: {{ $notifMaterial->id_boms }}</li>
                <br>
            @endforeach
        </ul>
        <br>
        <p>Terima kasih,<br>Steven Liong</p>
    </div>
</body>
</html>