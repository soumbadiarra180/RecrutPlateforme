<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'pays' => 'required|string|max:50',
            'indicatif' => 'required|string|max:5',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Un compte avec ces informations existe déjà. Connectez-vous plutôt.',
        ]);

        $validated['role'] = 'candidat';
        $telephoneComplet = $validated['indicatif'] . ' ' . $validated['telephone'];

        $nomComplet = explode(' ', $validated['name'], 2);
        $candidat = Candidat::create([
            'nom' => $nomComplet[0],
            'prenom' => $nomComplet[1] ?? '',
            'email' => $validated['email'],
            'telephone' => $telephoneComplet,
            'pays' => $validated['pays'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'id_candidat' => $candidat->id_candidat,
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Compte créé avec succès. Bienvenue !');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Connexion réussie.');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Déconnexion réussie.');
    }
}