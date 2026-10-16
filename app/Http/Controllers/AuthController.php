<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Contrôleur d'authentification (connexion / déconnexion des clients)
class AuthController extends Controller
{
    // Affiche la page de connexion
    public function showLogin()
    {
        // Si déjà connecté, redirige vers l'accueil
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    // Traite la tentative de connexion
    public function login(Request $request)
    {
        // Valide les champs du formulaire
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Veuillez saisir votre adresse email.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'password.required' => 'Veuillez saisir votre mot de passe.',
        ]);

        // Tente la connexion (avec "se souvenir de moi" si coché)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        // Échec : retour au formulaire avec un message d'erreur
        return back()->withErrors([
            'email' => 'Ces identifiants ne correspondent à aucun compte.',
        ])->onlyInput('email', 'remember');
    }

    // Déconnecte l'utilisateur
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');  // <- déjà vers l'accueil
    }
}
