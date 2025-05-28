<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
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

    public function show($id)
    {
        $company = Company::findOrFail($id);
        $employees = Company::with('workstations.users')->findOrFail($id);

        return view('company.show', compact('company', 'employees'));
    }

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
}