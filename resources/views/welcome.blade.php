<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Inventaris App') }}</title>

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f5f5f5;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 320px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .btn {
            display: block;
            margin: 10px 0;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        .login {
            background: grey;
            color: white;
        }

        .login:hover {
            background: rgb(94, 93, 93);
        }

        .register {
            background: rgb(73, 73, 73);
            color: white;
        }

        .register:hover {
            background: rgb(54, 54, 54);
        }
    </style>
</head>

<body>

<div class="card">
    <h1>{{ config('app.name', 'Laravel') }}</h1>
    <p>Welcome To Inventaris App</p>

    @if (Route::has('login'))
        @auth
            <a href="{{ url('/dashboard') }}" class="btn login">Go to Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn login">Login</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn register">Register</a>
            @endif
        @endauth
    @endif
</div>

</body>
</html>