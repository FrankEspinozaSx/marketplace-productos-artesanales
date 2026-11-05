<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace de Productos Artesanales - Hito 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* PALETA DE COLORES OFICIAL - HITO 1 */
            --color-primario: #75329F;       /* 600 - Navbar y botones principales */
            --color-secundario: #421C59;     /* 800 - Encabezados de tablas y acciones secundarias */
            --color-acento: #CBA6E3;         /* 200 - Insignias (badges) y bordes de resalte */
            --color-fondo: #F4ECF9;          /*  50 - Fondo general de la interfaz */
            --color-texto: #281136;          /* 900 - Color de texto de alto contraste */
            --color-primario-hover: #5C277C; /* 700 - Hover de boton primario */
        }

        body {
            background-color: var(--color-fondo);
            color: var(--color-texto);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-custom {
            background-color: var(--color-primario);
            border-bottom: 4px solid var(--color-acento);
        }
        .btn-primario {
            background-color: var(--color-primario);
            color: #ffffff;
            border: none;
        }
        .btn-primario:hover {
            background-color: var(--color-primario-hover);
            color: #ffffff;
        }
        .btn-secundario {
            background-color: var(--color-secundario);
            color: #ffffff;
            border: none;
        }
        .btn-secundario:hover {
            background-color: #281136;
            color: #ffffff;
        }
        .badge-acento {
            background-color: var(--color-acento);
            color: var(--color-texto);
            font-weight: 600;
        }
        .thead-branding th {
            background-color: var(--color-secundario) !important;
            color: #ffffff !important;
        }
        .encabezado-vista {
            border-left: 5px solid var(--color-primario);
            padding-left: 12px;
            color: var(--color-secundario);
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #F4ECF9;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffffff;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}"> Raices Marketplace</a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>

                    @auth
                        @if(auth()->user()->rol === 'artesano')
                            <li class="nav-item"><a class="nav-link" href="{{ route('artesano.metricas') }}">Panel de Metricas y Pedidos (Tablas)</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('artesano.productos.index') }}">Inventario Productos (Tabla)</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('artesano.productos.create') }}">Publicar y Configurar Tienda (Formulario)</a></li>
                        @elseif(auth()->user()->rol === 'comprador')
                            <li class="nav-item"><a class="nav-link" href="{{ route('comprador.catalogo') }}">Explorar Catalogo y Carrito (Tablas)</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('comprador.checkout.form') }}">Pago Seguro y Valoracion (Formulario)</a></li>
                        @endif
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Iniciar Sesion</a>
                        <a href="{{ route('register') }}" class="btn btn-secundario btn-sm">Registrarse</a>
                    @endguest

                    @auth
                        <span class="text-white small me-2">
                            Usuario: <strong>{{ auth()->user()->name }}</strong> 
                            <span class="badge badge-acento ms-1">{{ strtoupper(auth()->user()->rol) }}</span>
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Cerrar Sesion</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        @if(session('exito'))
            <div class="alert alert-success fw-semibold shadow-sm">{{ session('exito') }}</div>
        @endif
        @yield('contenido')
    </main>

    <footer class="py-3 bg-white border-top text-center small mt-auto shadow-sm">
        <div class="container">
            <strong style="color: var(--color-secundario);">4. Marketplace de Productos Artesanales</strong> | Lenguaje de Programacion III - Hito 1
        </div>
    </footer>

</body>
</html>
