@extends ('app')
@section('title', $model->name . ' - 3dWorld')
@section('content')
<div class="container">
    <div class="row p-2">
        <div class="col-12">
            <h1>{{ $model->name }}</h1>
        </div>
        
        <div class="container">
            <div class="row">
                <!-- Imagen -->
                <div class="col-md-6 col-sm-12 p-10">
                    @if ($model->image)
                    <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }}" class="img-fluid" style="max-height: 600px; width: 100%; object-fit: contain;">  
                    @else
                        <p>No image available</p>
                    @endif
                </div>

                <!-- Visor 3D para STL -->
                <div class="col-md-6 col-sm-12 p-10">
                    <div id="3d-visor" class="w-full" style="height: 500px;"></div> <!-- Contenedor del visor 3D -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Descripción</h5>
                    <p>{{ $model->description }}</p>
                </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/three@0.146.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.146.0/examples/js/loaders/STLLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.146.0/examples/js/controls/OrbitControls.js"></script> <!-- Incluir OrbitControls -->
<script>
    // Configuración básica de Three.js
    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    var renderer = new THREE.WebGLRenderer();
    
    // Fondo blanco
    renderer.setClearColor(0xFFFFFF, 1);  // Cambia el color de fondo a blanco

    // Ajustar el tamaño del visor 3D
    renderer.setSize(window.innerWidth / 2, 500);
    document.getElementById("3d-visor").appendChild(renderer.domElement);

    // Cargar el archivo STL
    var loader = new THREE.STLLoader();
    loader.load(
        '{{ asset("storage/" . $model->file) }}',  // Ruta al archivo STL desde la base de datos
        function (geometry) {
            var material = new THREE.MeshPhongMaterial({ color: 0x00ff00 });  // Usamos un material que responde a la luz
            var mesh = new THREE.Mesh(geometry, material);
            scene.add(mesh);
            
            // Calcular las dimensiones del modelo
            var bbox = new THREE.Box3().setFromObject(mesh);
            var size = new THREE.Vector3();
            bbox.getSize(size);
            
            // Calcular el factor de escala para que el modelo se ajuste al mismo tamaño
            var maxDimension = Math.max(size.x, size.y, size.z);  // Seleccionamos la dimensión más grande
            var scaleFactor = 1.0 / maxDimension;  // Escala inversa de la dimensión más grande

            // Ajustar escala para que todos los modelos se vean del mismo tamaño
            mesh.scale.set(scaleFactor, scaleFactor, scaleFactor);  // Aplica la escala

            // Ajustar la posición del modelo para centrarlo
            mesh.position.set(0, 0, 0);  // Posición del modelo en la escena
        },
        undefined,
        function (error) {
            console.error(error);  // Manejar errores en la carga
        }
    );

    // Configuración de la cámara
    camera.position.z = 1;  // Ajustar el zoom inicial (cámara más cerca)
    
    // Añadir controles interactivos (OrbitControls)
    var controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = true;  // Habilitar zoom
    controls.enableRotate = true;  // Habilitar rotación
    controls.enablePan = true;  // Habilitar desplazamiento

    // Añadir luz a la escena
    var ambientLight = new THREE.AmbientLight(0x404040);  // Luz ambiental suave
    scene.add(ambientLight);

    var directionalLight = new THREE.DirectionalLight(0xffffff, 1);  // Luz direccional más fuerte
    directionalLight.position.set(-2, 1, 5).normalize();  // Posición de la luz
    scene.add(directionalLight);

    // Función de animación
    function animate() {
        requestAnimationFrame(animate);
        controls.update();  // Actualizar controles en cada frame
        renderer.render(scene, camera);
    }

    animate();
</script>

@endsection
