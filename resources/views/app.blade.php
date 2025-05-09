<!-- filepath: /home/castillo/3dWorld/resources/views/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', '3dWorld'))</title>        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
        <!-- Scripts -->
        @vite(entrypoints: ['resources/js/app.js' ])
    </head>
    <body class="font-sans antialiased">
        
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand" href="/">3dWorld</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                  @guest
                    <!-- Mostrar Login y Register si el usuario no está autenticado -->
                    <li class="nav-item">
                      <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/register">Register</a>
                    </li>
                  @else
                    <!-- Mostrar Create y Profile si el usuario está autenticado -->
                    <li class="nav-item">
                      <a class="nav-link" href="/models3d/create"><i class="bi bi-plus-circle-fill"></i> Create</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/profile">Profile</a>
                    </li>
                    <!-- Opción para cerrar sesión -->
                    <li class="nav-item">
                      <form action="/logout" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-decoration-none">Logout</button>
                      </form>
                    </li>
                  @endguest
                </ul>
              </div>
            </div>
          </nav>

          @yield('content')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    </body>
</html>