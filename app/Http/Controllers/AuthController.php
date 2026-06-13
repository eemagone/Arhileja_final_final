<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Klients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister() { 
        return view('auth.register'); 
    }

    public function showLogin() { 
        return view('auth.login'); 
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'vards' => 'required|string|max:100',
            'uzvards' => 'required|string|max:100',
            'telnr' => 'nullable|string|max:20',
        ]);

        $user = User::create([ //user konts
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], //ir ka vnk teksts, jo insert skripti uzreiz bija uztaisiti
            'role' => 'klients' //registrejies vienmer ka klients
        ]);

        Klients::create([
            'user_id' => $user->id,
            'Vards' => $data['vards'],
            'Uzvards' => $data['uzvards'],
            'TelNr' => $data['telnr'],
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Laipni lūdzam, profils gatavs!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email', 
            'password' => 'required', 
        ]);

        $user = User::where('email', $credentials['email']) //parbaude
                    ->where('password', $credentials['password'])
                    ->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate(); 
            return redirect()->intended(route('dashboard')); 
        }

        return back()->withErrors([
            'email' => 'Hey vecais, nesakrīt kkas ar datiem! 💔',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect()->route('pricelist');
    }
}