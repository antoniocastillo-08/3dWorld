<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $model->name }}</title>
    @viteReactRefresh
    @vite('resources/js/app.jsx') <!-- Asegúrate de configurar Vite -->
</head>
<body>
    <div class="container">
        <h1>{{ $model->name }}</h1>
        <p>{{ $model->description }}</p>
        <div id="viewer-root" data-stl="{{ $model->stlFile }}"></div> <!-- Contenedor para React -->
    </div>
</body>
</html>