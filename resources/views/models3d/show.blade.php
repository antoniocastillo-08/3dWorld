@extends ('app')

@section('title', $model->name . ' - 3dWorld')

@section('content')
    <div class="min-h-screen py-10 px-4 bg-gradient-to-br from-white to-blue-300">
        <div class="max-w-6xl mx-auto space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-mono font-bold text-gray-800">{{ $model->name }}</h1>
                
                {{-- Botón de Like --}}
                <form
                    action="{{ $model->likedBy->contains(auth()->id()) ? route('models3d.unlike', $model->id) : route('models3d.like', $model->id) }}"
                    method="POST">
                    @csrf
                    <button type="submit"
                        class="text-gray-900 p-4 bg-white rounded-full hover:text-red-500 transition">
                        @if ($model->likedBy->contains(auth()->id()))
                            {{-- Ícono de "liked" --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        @else
                            {{-- Ícono de "no liked" --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        @endif
                    </button>
                </form>
            </div>

            <!-- Autor del modelo -->
            <h2 class="text-lg font-mono text-gray-600">
                Created by:
                @if ($model->author)
                    {{ $model->user->name }}
                @else
                    Unknown Author
                @endif
            </h2>

            <!-- Botón de descarga del STL -->
            <div class="flex gap-3 mt-4">
                @if ($model->file)
                    <a href="{{ asset('storage/' . $model->file) }}" download="{{ $model->name }}.stl"
                        class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        Download STL
                    </a>
                @endif
            </div>

            <!-- Botones Solo Accesibles por el Administrador y el autor de los modelos -->
            @if (auth()->check() && (auth()->id() === $model->author || auth()->user()->can('edit models') || auth()->user()->can('delete models')))
                <div class="flex gap-3 mt-4">
                    @if (auth()->id() === $model->author || auth()->user()->can('edit models'))
                        <a href="{{ route('models3d.edit', $model->id) }}"
                            class="bg-green-400 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
                            Edit
                        </a>
                    @endif

                    @if (auth()->id() === $model->author || auth()->user()->can('delete models'))
                        <form action="{{ route('models3d.destroy', $model->id) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar este modelo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Imagen -->
                <div class="bg-neutral-800 rounded-lg shadow">
                    @if ($model->image)
                        <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }}"
                            class="w-full h-[500px] object-contain rounded-lg shadow" />
                    @else
                        <div class="w-full h-[600px] flex items-center justify-center bg-gray-200 text-gray-500 rounded-lg">
                            No image available
                        </div>
                    @endif
                </div>

                <!-- Visor 3D -->
                <div>
                    <div id="3d-visor" class="w-full h-[500px] rounded-lg shadow border border-gray-300 relative"></div>
                </div>
            </div>
            <h2 class="text-xl font-semibold text-gray-700">Description</h2>
            <div class="bg-white px-10 py-6 rounded-lg shadow ">
                @if(!$model->description)
                    <p class="text-gray-600">No description</p>
                @else
                    <p class="text-gray-600">{{ $model->description }}</p>
                @endif
            </div>

        </div>
    </div>

    <!-- Scripts de Three.js -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.146.0/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.146.0/examples/js/loaders/STLLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.146.0/examples/js/controls/OrbitControls.js"></script>

    <script>
        const container = document.getElementById("3d-visor");
        const width = container.clientWidth;
        const height = container.clientHeight;
        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
        var renderer = new THREE.WebGLRenderer();
        renderer.setClearColor(0xFFFFFF, 1);
        renderer.setSize(width, height);
        document.getElementById("3d-visor").appendChild(renderer.domElement);

        var loader = new THREE.STLLoader();
        loader.load(
            '{{ asset("storage/" . $model->file) }}',
            function (geometry) {
                var material = new THREE.MeshPhongMaterial({ color: 0x00ff00 });
                var mesh = new THREE.Mesh(geometry, material);
                scene.add(mesh);

                var bbox = new THREE.Box3().setFromObject(mesh);
                var size = new THREE.Vector3();
                bbox.getSize(size);
                var maxDimension = Math.max(size.x, size.y, size.z);
                var scaleFactor = 1.0 / maxDimension;
                mesh.scale.set(scaleFactor, scaleFactor, scaleFactor);
                mesh.position.set(0, 0, 0);
            },
            undefined,
            function (error) {
                console.error(error);
            }
        );

        camera.position.z = 1.3;
        var controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableZoom = true;
        controls.enableRotate = true;
        controls.enablePan = true;

        var ambientLight = new THREE.AmbientLight(0x404040);
        scene.add(ambientLight);

        var directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(-2, 1, 5).normalize();
        scene.add(directionalLight);

        function animate() {
            requestAnimationFrame(animate);
            controls.update();
            renderer.render(scene, camera);
        }

        animate();
    </script>
@endsection