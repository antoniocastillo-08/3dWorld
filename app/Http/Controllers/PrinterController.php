<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrinterRequest;
use App\Http\Requests\UpdatePrinterRequest;
use App\Models\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user= auth()->user();
        $printers = $user->printers;  
    
        return view('printers.index', compact('printers'));
    }


    public function add()
    {
        
        $printers = Printer::all();  
        $printersByBrand = $printers->groupBy('brand');

        return view('printers.add_printer', compact('printersByBrand'));
    }
    public function attach(Request $request)
{
    // Validar el ID de la impresora
    $request->validate([
        'printer_id' => 'required|exists:printers,id',
    ]);

    // Obtener el usuario autenticado
    $user = Auth::user();

    // Adjuntar la impresora al usuario (many-to-many)
    $user->printers()->syncWithoutDetaching([$request->printer_id]);

    // Redirigir con un mensaje de éxito
    return redirect()->back()->with('success', 'Impresora añadida correctamente.');
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrinterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Printer $printer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Printer $printer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrinterRequest $request, Printer $printer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Printer $printer)
    {
        //
    }
}
