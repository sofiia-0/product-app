<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product App</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #E8E2D4;
            color: #436741;
            margin: 0;
        }
        .container {
            max-width: 480px;
            margin: 7vh auto;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 6px 32px #43674122;
            padding: 3rem 2.2rem 2.2rem 2.2rem;
            border: 2.5px solid #E1C1C6;
        }
        .app-illustration {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 0; /* No espacio entre sección e h1 */
        }
        .app-illustration img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 18px;
            box-shadow: 0 4px 18px #43674133;
            margin-bottom: 1rem; /* Espacio entre imagen y descubre */
            background: #E8E2D4;
        }
        .nuevo-producto {
            font-size: 1.25rem;
            font-weight: 700;
            color: #436741;
            background: linear-gradient(90deg, #E1C1C6 0%, #E8E2D4 100%);
            padding: 0.5rem 1.5rem;
            border-radius: 16px;
            margin-bottom: 0.4rem; /* Pequeño espacio con h1 */
            letter-spacing: 2px;
            box-shadow: 0 2px 8px #E1C1C655;
            border: 2px solid #436741;
            text-transform: uppercase;
            transition: background .2s, color .2s;
        }
        .nuevo-producto:hover {
            background: #436741;
            color: #E8E2D4;
        }
        h1 {
            font-size: 2.3rem;
            margin: 0; /* Sin espacio arriba ni abajo */
            font-weight: 700;
            color: #436741;
            letter-spacing: -1px;
        }
        p {
            color: #6b7a5e;
            margin-bottom: 2.2rem;
            font-size: 1.08rem;
        }
        .btn {
            display: inline-block;
            padding: .85rem 2rem;
            border-radius: 10px;
            background: #436741;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.08rem;
            border: none;
            box-shadow: 0 2px 8px #43674122;
            transition: background .2s, color .2s;
        }
        .btn:hover {
            background: #E1C1C6;
            color: #436741;
        }
        nav {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-bottom: 2.2rem;
        }
        .btn-outline {
            background: #fff;
            color: #436741;
            border: 2px solid #436741;
        }
        .btn-outline:hover {
            background: #E1C1C6;
            color: #436741;
        }
        .link {
            color: #436741;
            text-decoration: underline;
            font-weight: 500;
        }
        .card {
            background: #E8E2D4;
            border-radius: 10px;
            padding: 1.2rem 1rem;
            margin-top: 2rem;
            text-align: center;
        }
        @media (max-width: 600px) {
            .container { padding: 1.2rem; }
            h1 { font-size: 1.5rem; }
            .app-illustration img { width: 100px; height: 100px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="app-illustration">
            <img src="https://i.pinimg.com/736x/b1/cc/e7/b1cce7584b6ed842500a3c7bb2750dad.jpg" alt="Nuevo Producto">
            <div class="nuevo-producto">¡Descubre el nuevo producto!</div>
        </div>
        <h1>Bienvenido a Product App</h1>
        <p>Gestiona tus productos y categorías de forma simple.<br>
        Registra productos y asócialos fácilmente a sus categorías.</p>
        <nav>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Iniciar sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline">Registrarse</a>
                    @endif
                @endauth
            @endif
        </nav>
        <a href="{{ route('products.index') }}" class="btn" style="margin-bottom:1.5rem;">Ver productos</a>
    </div>
</body>
</html>
