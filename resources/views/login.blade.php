<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <title>Inversiones OSA | Panel Administrativo</title>
    <!-- Css Files -->
    <link href="{{ asset('/css/root.css') }}" rel="stylesheet">
    <style type="text/css">
        body {
            background: #F5F5F5;
        }
    </style>
</head>
<body>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">IO</h1>
            </div>
            <h3>Bienvenido a Inversiones OSA</h3>
            <p>Sistema administrativo y control</p>
            <form class="m-t" method="get" action="/redirect">
                <button type="submit" class="btn btn-primary block full-width m-b"><i class="fa fa-google"></i>Iniciar sesión con Google</button>
            </form>
            <p class="m-t"> <small>&copy; {{ \Carbon\Carbon::now()->year }}</small> </p>
        </div>
    </div>
</body>
</html>