<?php
namespace App\Http\Controllers;

use App\Models\UserPrinter;
use App\Models\Model3d;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        $printers = UserPrinter::where('workstation_id', $user->workstation_id)->with('printer')->get();
    
        $likedModels = $user->likedModels()->with('user')->get();
    
        $userModels = Model3d::where('author', $user->id)->get();
    
        return view('dashboard', compact('printers', 'likedModels', 'userModels'));
    }
    
}