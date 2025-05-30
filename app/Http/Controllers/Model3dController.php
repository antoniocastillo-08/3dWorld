<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModel3dRequest;
use App\Http\Requests\UpdateModel3dRequest;
use App\Models\Model3d;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPrinter;
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

        $models = $query->paginate(16)->appends($request->all());
       
        $printers = auth()->check()
            ? UserPrinter::where('workstation_id', auth()->user()->workstation_id)->with('printer')->get()
            : collect();


        // Pasar las variables a la vista
        return view('welcome', compact('models', 'printers'));
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
        // Validación de los datos recibidos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'image' => 'nullable|file|max:20000', // Validación básica para imágenes
            'file' => 'nullable|file|max:512000', // Validación básica para archivos STL
        ]);

        // Validación personalizada para extensiones
        if ($request->hasFile('image') && !in_array(strtolower($request->file('image')->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif'])) {
            return back()->withErrors(['image' => 'La imagen debe ser un archivo de tipo: jpg, jpeg, png, gif.']);
        }

        if ($request->hasFile('file') && strtolower($request->file('file')->getClientOriginalExtension()) !== 'stl') {
            return back()->withErrors(['file' => 'El archivo debe ser de tipo STL.']);
        }

        // Crea una nueva instancia del modelo
        $model3d = new Model3d();

        // Asigna los datos del formulario
        $model3d->name = $request->name;
        $model3d->description = $request->description;
        $model3d->author = Auth::id();

        // Maneja la subida de la imagen
        if ($request->hasFile('image')) {
            $model3d->image = $request->file('image')->storeAs(
                'models/' . $request->name,
                'image.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );
        }

        // Maneja la subida del archivo STL
        if ($request->hasFile('file')) {
            $model3d->file = $request->file('file')->storeAs(
                'models/' . $request->name,
                'model.stl',
                'public'
            );
        }

        // Guarda el modelo en la base de datos
        $model3d->save();

        return redirect()->route('models3d.index')->with('success', 'Modelo 3D subido exitosamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Model3d $model)
    {
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

        // Validación de los datos recibidos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|max:20000', // Validación básica para imágenes
            'file' => 'nullable|file|max:512000', // Validación básica para archivos STL
        ]);

        // Validación personalizada para extensiones
        if ($request->hasFile('image') && !in_array($request->file('image')->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            return back()->withErrors(['image' => 'La imagen debe ser un archivo de tipo: jpg, jpeg, png, gif.']);
        }

        if ($request->hasFile('file') && $request->file('file')->getClientOriginalExtension() !== 'stl') {
            return back()->withErrors(['file' => 'El archivo debe ser de tipo STL.']);
        }

        // Actualiza los campos básicos
        $model->name = $request->input('name');
        $model->description = $request->input('description');

        // Manejo de la carpeta del modelo
        $oldFolder = 'models/' . $model->getOriginal('name');
        $newFolder = 'models/' . $model->name;

        if ($oldFolder !== $newFolder && Storage::exists($oldFolder)) {
            Storage::move($oldFolder, $newFolder);
        }

        // Manejo de la imagen
        if ($request->hasFile('image')) {
            Storage::delete($newFolder . '/' . $model->image);
            $model->image = $request->file('image')->storeAs(
                $newFolder,
                'image.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );
        }

        // Manejo del archivo STL
        if ($request->hasFile('file')) {
            Storage::delete($newFolder . '/' . $model->file);
            $model->file = $request->file('file')->storeAs(
                $newFolder,
                'model.stl',
                'public'
            );
        }

        // Guarda los cambios en la base de datos
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
        if (Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->deleteDirectory($folder);
        }

        // Elimina el registro del modelo de la base de datos
        $model->delete();

        return redirect()->route('models3d.index')->with('success', 'Modelo eliminado correctamente.');
    }

    public function like($id)
    {
        $model = Model3d::findOrFail($id);

        // Verificar si el usuario ya dio "like"
        if ($model->likedBy()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()->with('info', 'You already liked this model.');
        }

        // Registrar el "like"
        $model->likedBy()->attach(auth()->id());

        return redirect()->back()->with('success', 'You liked this model!');
    }
    public function unlike($id)
    {
        $model = Model3d::findOrFail($id);

        // Eliminar el "like"
        $model->likedBy()->detach(auth()->id());

        return redirect()->back()->with('success', 'You unliked this model!');
    }
}