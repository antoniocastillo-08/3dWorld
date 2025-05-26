<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Workstation;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Crear una estación de trabajo individual para el usuario
        $workstation = Workstation::create([
            'name' => $user->name . "'s Workstation",
            'type' => 'individual',
        ]);
    
        // Asociar la estación de trabajo al usuario
        $user->workstation_id = $workstation->id;
        $user->save();
    
        event(new Registered($user));
    
        Auth::login($user);
    
        return redirect(route('dashboard', absolute: false));
    }
    protected function authenticated(Request $request, $user)
    {
        if (is_null($user->workstation_id)) {
            // Crear una estación de trabajo individual si no tiene una
            $workstation = Workstation::create([
                'name' => $user->name . "'s Workstation",
                'type' => 'individual',
            ]);
    
            // Asociar la estación de trabajo al usuario
            $user->workstation_id = $workstation->id;
            $user->save();
        }
    
        return redirect()->intended($this->redirectPath());
    }
}
