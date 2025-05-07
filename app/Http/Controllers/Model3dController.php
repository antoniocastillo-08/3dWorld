<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModel3dRequest;
use App\Http\Requests\UpdateModel3dRequest;
use App\Models\Model3d;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Model3dController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Model3d::all(); // O usa paginación si es necesario
        return Inertia::render('Modelos3d', [
            'models' => $models
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('UploadModel', [
            'model' => new Model3d()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Crea una nueva instancia del modelo
        $model3d = new Model3d();

        // Asigna los datos del formulario
        $model3d->name = $request->name;
        $model3d->description = $request->description;

        // Asocia el modelo con el usuario autenticado
        $model3d->author = Auth::id();

        // Maneja la subida de la imagen
        if ($request->hasFile('image')) {
            $model3d->image = $request->file('image')->storeAs(
                $request->name, // Crea una subcarpeta con el nombre del modelo
                $request->file('image')->getClientOriginalName(),
                'public'
            );
        }

        // Maneja la subida del archivo STL
        if ($request->hasFile('file')) {
            $model3d->file = $request->file('file')->storeAs(
                $request->name, // Crea una subcarpeta con el nombre del modelo
                $request->file('file')->getClientOriginalName(),
                'public'
            );
        }

        // Guarda el modelo en la base de datos
        $model3d->save();

        // Redirige con un mensaje de éxito
        return redirect()->route('models3d.index')->with('success', 'Modelo 3D subido exitosamente.');
    }

    
    /**
     * Display the specified resource.
     */
    public function show(Model3d $model3d)
    {
        return Inertia::render('Modelo3dIndividual', [
        'model' => $model3d
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Model3d $model3d)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModel3dRequest $request, Model3d $model3d)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model3d $model3d)
    {
        //
    }
}
