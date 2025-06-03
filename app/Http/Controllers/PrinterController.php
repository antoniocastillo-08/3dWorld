<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrinterRequest;
use App\Models\Printer;
use App\Models\UserPrinter;
use App\Models\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FilamentPrinter;

class PrinterController extends Controller
{

    // Muestra el listado de impresoras y filamentos
    public function index()
    {
        $workstationId = Auth::user()->workstation_id;

        // Si el usuario no tiene una estación de trabajo, no mostrar impresoras
        if (is_null($workstationId)) {
            $printers = collect(); // Colección vacía
            $filaments = collect(); // Colección vacía
        } else {
            // Filtrar impresoras y filamentos por workstation_id
            $printers = UserPrinter::where('workstation_id', $workstationId)->with('printer')->get();
            $filaments = Filament::where('workstation_id', $workstationId)->get();
        }

        return view('printers.index', compact('printers', 'filaments'));
    }

    // Muestra el formulario para agregar una nueva impresora
    public function add()
    {

        $printers = Printer::all();
        $printersByBrand = $printers->groupBy('brand');

        return view('printers.add_printer', compact('printersByBrand'));
    }

    // Muestra el formulario para personalizar una impresora específica
    public function customize($printerId)
    {
        // Obtener la impresora seleccionada
        $printer = Printer::findOrFail($printerId);

        // Retornar la vista del formulario con la impresora seleccionada
        return view('printers.attach_printer', compact('printer'));
    }


    // Muestra el formulario para adjuntar una impresora a la estación de trabajo del usuario
    public function attach(Request $request)
    {
        $request->validate([
            'printer_id' => 'required|exists:printers,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:Available,On Use,Not Available',
            'nozzle_size' => 'nullable|numeric|min:0.1',
        ]);

        // Crear una nueva relación en la tabla UserPrinter
        UserPrinter::create([
            'printer_id' => $request->printer_id,
            'name' => $request->name,
            'status' => $request->status,
            'nozzle_size' => $request->nozzle_size,
            'workstation_id' => Auth::user()->workstation_id, // Asociar a la estación de trabajo del usuario
        ]);

        return redirect()->route('printers.index')->with('success', 'Printer attached successfully.');
    }

    // Muestra el formulario para editar una impresora específica
    public function edit($id)
    {
        // Obtener la impresora específica
        $userPrinter = UserPrinter::with('printer')->findOrFail($id);

        // Verificar si la impresora pertenece a la misma workstation que el usuario o si el usuario es administrador
        if ($userPrinter->workstation_id !== auth()->user()->workstation_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Obtener los filamentos disponibles en el inventario del usuario
        $filaments = Filament::where('workstation_id', auth()->user()->workstation_id)->get();

        // Obtener los filamentos asignados a la impresora desde la tabla intermedia
        $filamentsPrinters = FilamentPrinter::where('printer_user_id', $id)
            ->with('filament') // Cargar la relación con el modelo Filament
            ->get();

        // Retornar la vista con las tres variables
        return view('printers.edit', compact('userPrinter', 'filaments', 'filamentsPrinters'));
    }

    // Actualiza las notas de una impresora específica
    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:5000',
        ]);

        $userPrinter = UserPrinter::findOrFail($id);

        // Verificar que el usuario tenga permiso para editar esta impresora
        if ($userPrinter->workstation_id !== auth()->user()->workstation_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $userPrinter->notes = $request->notes;
        $userPrinter->save();

        return redirect()->back()->with('success', 'Notes updated successfully.');
    }

    public function update(Request $request, $id)
    {
        $userPrinter = UserPrinter::findOrFail($id);

        // Verificar si la impresora pertenece a la misma workstation que el usuario o si el usuario es administrador
        if ($userPrinter->workstation_id !== auth()->user()->workstation_id && !auth()->user()->hasRole('admin')) {
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

    // Elimina una impresora específica
    public function destroy($id)
    {
        $userPrinter = UserPrinter::findOrFail($id);

        // Verificar si la impresora pertenece a la misma workstation que el usuario o si el usuario es administrador
        if ($userPrinter->workstation_id !== auth()->user()->workstation_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $userPrinter->delete();

        return redirect()->route('printers.index')->with('success', 'Printer deleted successfully.');
    }

    // Agrega un filamento a una impresora específica
    public function addFilament(Request $request, $printerId, $filamentId)
    {
        // Buscar la impresora y el filamento
        $printer = UserPrinter::findOrFail($printerId);
        $filament = Filament::findOrFail($filamentId);

        // Verificar si el filamento ya está asignado a la impresora
        $exists = FilamentPrinter::where('printer_user_id', $printerId)
            ->where('filament_id', $filamentId)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'This filament is already assigned to the printer.');
        }

        // Verificar si hay suficiente cantidad del filamento
        if ($filament->amount <= 0) {
            return redirect()->back()->with('error', 'Not enough filament available.');
        }

        // Crear la relación en la tabla intermedia
        FilamentPrinter::create([
            'printer_user_id' => $printerId,
            'filament_id' => $filamentId,
        ]);

        // Reducir el amount del filamento
        $filament->decrement('amount');

        return redirect()->back()->with('success', 'Filament added to the printer successfully.');
    }
    // Elimina un filamento de una impresora específica
    public function removeFilament($printerId, $filamentId)
    {
        // Buscar la relación específica en la tabla intermedia
        $relation = FilamentPrinter::where('printer_user_id', $printerId)
            ->where('filament_id', $filamentId)
            ->first();

        if ($relation) {
            // Eliminar la relación específica
            $relation->delete();

            // Incrementar el amount del filamento
            $filament = Filament::findOrFail($filamentId);
            $filament->increment('amount');

            return redirect()->back()->with('success', 'Filament removed from the printer successfully.');
        } else {
            return redirect()->back()->with('error', 'The filament is not assigned to this printer.');
        }
    }
}
