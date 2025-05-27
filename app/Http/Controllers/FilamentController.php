<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilamentRequest;
use App\Http\Requests\UpdateFilamentRequest;
use App\Models\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Verificar si el usuario tiene una estación de trabajo asociada
        if (is_null($user->workstation_id)) {
            return redirect()->route('company.options')->with('error', 'You must belong to a company to access filaments.');
        }

        // Lógica para crear filamentos
        return view('filaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'material' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'diameter' => 'required|numeric|min:0.1',
            'weight' => 'required|numeric',
            'amount' => 'required|integer',
        ]);

        // Crea una nueva instancia del modelo Filament
        $filament = new Filament();

        // Asigna los datos del formulario
        $filament->material = $request->material;
        $filament->brand = $request->brand;
        $filament->color = $request->color;
        $filament->diameter = $request->diameter;
        $filament->weight = $request->weight;
        $filament->amount = $request->amount;
        $filament->workstation_id = auth()->user()->workstation_id;
        // Guarda el filamento en la base de datos
        $filament->save();

        // Redirige al listado de filamentos con un mensaje de éxito
        return redirect()->route('printers.index')->with('success', 'Filament added successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Filament $filament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Obtener los filamentos asociados a la estación de trabajo del usuario
        $filaments = Filament::where('workstation_id', auth()->user()->workstation_id)->get();
    
        // Retornar la vista de edición con los filamentos
        return view('filaments.edit', compact('filaments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $filaments = $request->input('filaments', []);
    
        foreach ($filaments as $id => $data) {
            $filament = Filament::findOrFail($id);
            $filament->update($data);
        }
    
        return redirect()->route('printers.index')->with('success', 'Filaments updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filament $filament)
    {
        // Verificar si el filamento pertenece al usuario actual
        if ($filament->workstation_id !== auth()->user()->workstation_id) {
            return redirect()->route('printers.index')->with('error', 'Unauthorized action.');
        }
    
        // Eliminar el filamento
        $filament->delete();
    
        return redirect()->route('printers.index')->with('success', 'Filament removed successfully.');
    }

}
