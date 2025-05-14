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

        return view('dashboard', compact('printers'));
    }
}