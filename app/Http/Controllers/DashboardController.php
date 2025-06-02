<?php
namespace App\Http\Controllers;

use App\Models\UserPrinter;
use App\Models\Model3d;

class DashboardController extends Controller
{
    public function index()
    {
        // Verifica si el usuario está autenticado
        $user = auth()->user();

        // Si el usuario no está autenticado, redirige a la página de inicio de sesión
        $printers = UserPrinter::where('workstation_id', $user->workstation_id)->with('printer')->get();
    
        // Obtiene los modelos 3D que el usuario ha dado "me gusta"
        $likedModels = $user->likedModels()->with('user')->get();
    
        // Obtiene los modelos 3D que el usuario ha creado
        $userModels = Model3d::where('author', $user->id)->get();
    
        return view('dashboard', compact('printers', 'likedModels', 'userModels'));
    }
    
}