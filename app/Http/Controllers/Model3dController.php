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
    public function index(Request $request)
    {
        $query = Model3D::query();

        // Búsqueda por nombre
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Orden alfabético
        if ($request->filled('name_order')) {
            $query->orderBy('name', $request->name_order);
        }

        // Orden por fecha de subida
        if ($request->filled('date_order')) {
            $query->orderBy('created_at', $request->date_order == 'newest' ? 'desc' : 'asc');
        }

        $models = $query->get();

        return view('welcome', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('models3d.create');
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
                'models/' . $request->name,
                $request->file('image')->getClientOriginalName(),
                'public'
            );
        }

        // Maneja la subida del archivo STL
        if ($request->hasFile('file')) {
            $model3d->file = $request->file('file')->storeAs(
                'models/' . $request->name, // Crea una subcarpeta con el nombre del modelo
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
    public function show(Model3d $model)
    {
        $model->load('author');
        return view('models3d.show', ['model' => $model]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = Model3d::findOrFail($id);

        // Verifica si el usuario es el autor o tiene permiso para editar
        if (Auth::id() !== $model->author && !Auth::user()->can('edit models')) {
            abort(403, 'No tienes permiso para editar este modelo.');
        }

        return view('models3d.edit', compact('model'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Model3d::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
            'file' => 'nullable|mimes:stl|max:10240',
        ]);

        // Ruta actual de la carpeta del modelo
        $oldFolder = 'models/' . $model->name;

        // Si el nombre del modelo cambia, renombramos la carpeta
        if ($model->name !== $request->input('name')) {
            $newFolder = 'models/' . $request->input('name');
            if (Storage::exists($oldFolder)) {
                Storage::move($oldFolder, $newFolder);
            }
            $model->name = $request->input('name');
        }

        $model->description = $request->input('description');

        // Manejo de la imagen
        if ($request->hasFile('image')) {
            // Elimina la imagen anterior si existe
            Storage::delete($oldFolder . '/' . $model->image);

            // Guarda la nueva imagen en la carpeta correspondiente
            $model->image = $request->file('image')->storeAs(
                $oldFolder, // Usa la carpeta actual del modelo
                'image.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );
        }

        // Manejo del archivo STL
        if ($request->hasFile('file')) {
            // Elimina el archivo STL anterior si existe
            Storage::delete($oldFolder . '/' . $model->file);

            // Guarda el nuevo archivo STL en la carpeta correspondiente
            $model->file = $request->file('file')->storeAs(
                $oldFolder, // Usa la carpeta actual del modelo
                'model.stl',
                'public'
            );
        }

        $model->save();

        return redirect()->route('models3d.show', $model->id)->with('success', 'Modelo actualizado correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $model = Model3d::findOrFail($id);

    // Verifica si el usuario es el autor o tiene permiso para borrar
    if (Auth::id() !== $model->author && !Auth::user()->can('delete models')) {
        abort(403, 'No tienes permiso para eliminar este modelo.');
    }

    // Ruta de la carpeta del modelo
    $folder = 'models/' . $model->name;

    // Elimina la carpeta completa si existe
    if (Storage::exists($folder)) {
        Storage::deleteDirectory($folder);
    }

    // Elimina el registro del modelo de la base de datos
    $model->delete();

    return redirect()->route('models3d.index')->with('success', 'Modelo eliminado correctamente.');
}
}