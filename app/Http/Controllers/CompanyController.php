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
        // Obtener todas las empresas disponibles
        $companies = Company::all();

        // Pasar las empresas a la vista
        return view('company.options', compact('companies'));
    }

    public function createCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
        ]);

        // Crear la empresa
        $company = Company::create([
            'name' => $request->name,
        ]);

        // Crear una estación de trabajo con el mismo nombre que la empresa
        $workstation = Workstation::create([
            'name' => $company->name,
            'company_id' => $company->id,
        ]);

        // Asignar la estación de trabajo al usuario
        $user = Auth::user();
        $user->workstation_id = $workstation->id;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Company and workstation created successfully.');
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

    public function noCompany()
    {
        $user = Auth::user();
        $user->workstation_id = null;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'You have chosen not to be part of a company.');
    }


}