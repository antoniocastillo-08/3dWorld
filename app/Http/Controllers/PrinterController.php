<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrinterRequest;
use App\Http\Requests\UpdatePrinterRequest;
use App\Models\Printer;
use App\Models\UserPrinter;
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
        $printers = UserPrinter::where('user_id', $user->id)->with('printer')->get();
    
        return view('printers.index', compact('printers'));
    }


    public function add()
    {
        
        $printers = Printer::all();  
        $printersByBrand = $printers->groupBy('brand');

        return view('printers.add_printer', compact('printersByBrand'));
    }    

    public function customize($printerId)
    {
        // Obtener la impresora seleccionada
        $printer = Printer::findOrFail($printerId);
    
        // Retornar la vista del formulario con la impresora seleccionada
        return view('printers.attach_printer', compact('printer'));
    }


    public function attach(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'printer_id' => 'required|exists:printers,id',
            'name' => 'required|string|max:255', // Nombre personalizado
            'status' => 'required|in:Available,On Use,Not Available', // Estado
            'nozzle_size' => 'numeric|min:0.1', // Tamaño de la boquilla
        ]);
    
        // Crear la relación en la tabla pivot
        UserPrinter::create([
            'user_id' => Auth::id(),
            'printer_id' => $request->printer_id,
            'name' => $request->name,
            'status' => $request->status,
            'nozzle_size' => $request->nozzle_size,
        ]);
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('printers.index')->with('success', 'Impresora añadida correctamente.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrinterRequest $request)
    {
        
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
    public function edit($id)
    {
        $userPrinter = UserPrinter::findOrFail($id);
    
        // Verifica si el usuario es el propietario o tiene el rol de administrador
        if (auth()->id() !== $userPrinter->user_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
    
        return view('printers.edit', compact('userPrinter'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $userPrinter = UserPrinter::findOrFail($id);
    
        // Verifica si el usuario es el propietario o tiene el rol de administrador
        if (auth()->id() !== $userPrinter->user_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
    
        // Validar los datos recibidos
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Available,On Use,Not Available',
            'nozzle_size' => 'nullable|numeric|min:0.1',
        ]);
    
        // Actualizar los datos en la tabla user_printers
        $userPrinter->update([
            'name' => $request->name,
            'status' => $request->status,
            'nozzle_size' => $request->nozzle_size,
        ]);
    
        return redirect()->route('printers.index')->with('success', 'Impresora actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userPrinter = UserPrinter::findOrFail($id);
    
        // Verifica si el usuario es el propietario o tiene el rol de administrador
        if (auth()->id() !== $userPrinter->user_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
    
        $userPrinter->delete();
    
        return redirect()->route('printers.index')->with('success', 'Printer deleted successfully.');
    }
}
