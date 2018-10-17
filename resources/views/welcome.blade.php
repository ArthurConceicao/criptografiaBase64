<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="top-right links">
        <a href="{{ url('/home') }}">Home</a>
    </div>

    <div class="content">
        <div class="title m-b-md">
            Criptografia
        </div>

        <div>
            <form action="{{ route('criptografar') }}" method="post">
                <input type="text" name="texto_original" required/>
                <input type="submit" value="Criptografar">
                {{ csrf_field() }}
            </form>
            <form action="{{ route('descriptografar') }}" method="post">
                <input type="text" name="texto_criptografado" required/>
                <input type="submit" value="Descriptografar">
                {{ csrf_field() }}
            </form>
        </div>
        <div>
            @if($textoCriptografado)
                <h4>{{ $textoCriptografado }}</h4>
            @endif
            @if($textoDesriptografado)
                <h4>{{ $textoDesriptografado }}</h4>
            @endif
        </div>
    </div>
</div>
</body>
</html>
