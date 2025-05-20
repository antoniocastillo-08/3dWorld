<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPrinter;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Obtener las impresoras asociadas al usuario
        $printers = UserPrinter::where('user_id', $user->id)->with('printer')->get();

        // Obtener los modelos 3D a los que se les ha dado like
        $likedModels = $user->likedModels()->with('user')->get();


        return view('dashboard', compact('printers', 'likedModels'));
    }
}