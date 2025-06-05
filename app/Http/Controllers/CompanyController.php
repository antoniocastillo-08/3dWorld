<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\JoinRequest;
class CompanyController extends Controller
{
    //Funcion para mostrar las opciones de empresa
    public function showOptions()
    {
        $user = Auth::user();

        // Si el usuario ya tiene una workstation, redirige a la empresa correspondiente
        if ($user->workstation && $user->workstation->company) {
            return redirect()->route('company.show', $user->workstation->company->id);
        }

        // Mostrar la vista de opciones si no pertenece a una empresa
        $companies = Company::all();
        return view('company.options', compact('companies'));
    }

    // Unirse a una empresa existente
    public function joinCompany(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        // Asignar la estación de trabajo de la empresa al usuario
        $workstation = Workstation::where('company_id', $request->company_id)->first();
        $user = Auth::user();
        $user->workstation_id = $workstation->id;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'You have joined the company successfully.');
    }

    // Crear una nueva empresa
    public function create()
    {
        // Mostrar la vista para crear una empresa
        return view('company.create');
    }

    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email|unique:companies,email',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        // Crear la empresa
        $company = Company::create($validated);

        // Crear una estación de trabajo con el mismo nombre que la empresa
        $workstation = Workstation::create([
            'name' => $company->name,
            'company_id' => $company->id,
        ]);

        // Asignar la estación de trabajo al usuario
        $user = Auth::user();
        $user->workstation_id = $workstation->id;
        $user->save();

        // Asignar el rol de "Boss" al usuario
        $user->assignRole('boss');

        // Redirigir a la vista de la empresa
        return redirect()->route('company.show', $company->id);
    }

    // Mostrar los detalles de la empresa
    public function show($id)
    {
        $company = Company::findOrFail($id);
        $employees = Company::with('workstations.users')->findOrFail($id);

        return view('company.show', compact('company', 'employees'));
    }

    // Editar los detalles de la empresa (Solo para el jefe)
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $id,
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email|unique:companies,email,' . $id,
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $company->update($validated);

        return redirect()->route('company.show', $company->id)->with('success', 'Company updated successfully.');
    }

    // Despedir a un empleado (Solo para el jefe)
    public function fire(User $user)
    {
        if (!Auth::user()->hasRole('boss')) {
            abort(403);
        }

        // Eliminar la relación con la workstation
        $user->workstation_id = null;
        $user->save();

        return back()->with('success', 'Employee fired successfully.');
    }

    // Solicitar unirse a una empresa
    public function requestJoinCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|exists:companies,name',
        ]);

        $company = Company::where('name', $request->company_name)->first();

        if (!$company) {
            return back()->withErrors(['company_name' => 'Company not found.']);
        }

        JoinRequest::firstOrCreate([
            'user_id' => Auth::id(),
            'company_id' => $company->id,
        ]);

        return back()->with('success', 'Request sended to boss.');
    }


    // Mostrar las solicitudes de unión pendientes (Solo para el jefe)
    public function respondToJoinRequest(Request $request, JoinRequest $joinRequest)
    {
        if (!Auth::user()->hasRole('boss')) {
            abort(403);
        }

        if ($request->action === 'accept') {
            $user = $joinRequest->user;
            $workstation = Workstation::where('company_id', $joinRequest->company_id)->first();

            $user->workstation_id = $workstation->id;
            $user->save();

            $joinRequest->status = 'accepted';
        } else {
            $joinRequest->status = 'rejected';
        }

        $joinRequest->save();

        return back()->with('success', 'Sent');
    }
    // Eliminar una empresa (Solo para el jefe)
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        // Solo el jefe puede eliminar la empresa
        if (!Auth::user()->hasRole('boss')) {
            abort(403);
        }

        // Elimina todos los usuarios relacionados (opcional: podrías querer solo desvincularlos)
        foreach ($company->workstations as $workstation) {
            foreach ($workstation->users as $user) {
                $user->workstation_id = null;
                $user->removeRole('boss'); // Quitar rol si es necesario
                $user->save();
            }
            $workstation->delete(); // eliminar estaciones de trabajo
        }

        $company->delete(); // eliminar empresa

        return redirect()->route('dashboard')->with('success', 'Company deleted successfully.');
    }

}