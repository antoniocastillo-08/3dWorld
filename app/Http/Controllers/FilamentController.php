<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilamentRequest;
use App\Http\Requests\UpdateFilamentRequest;
use App\Models\Filament;
use Illuminate\Http\Request;

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
        $filament->filament_user_id = auth()->id();

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
    public function edit(Filament $filament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilamentRequest $request, Filament $filament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filament $filament)
    {
        // Verifica si el filamento existe
        if (!$filament) {
            return redirect()->route('printers.index')->with('error', 'Filament not found.');
        }

        // Elimina el filamento
        $filament->delete();

        // Redirige al listado de filamentos con un mensaje de éxito
        return redirect()->route('printers.index')->with('success', 'Filament deleted successfully.');
    }
}
