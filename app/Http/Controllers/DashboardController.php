<?php
namespace App\Http\Controllers;

use App\Models\UserPrinter;
use App\Models\Model3d;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Obtener las impresoras asociadas al usuario
        $printers = UserPrinter::where('workstation_id', $user->id)->with('printer')->get();

        // Obtener los modelos 3D a los que se les ha dado like
        $likedModels = $user->likedModels()->with('user')->get();

        // Obtener los modelos 3D subidos por el usuario
        $userModels = Model3d::where('author', $user->id)->get();

        return view('dashboard', compact('printers', 'likedModels', 'userModels'));
    }
}