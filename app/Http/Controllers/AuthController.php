<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    // Affiche la page d'inscription
    public function showRegister()
    {
        // Si déjà connecté, redirige vers l'accueil
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    // Traite la création d'un nouveau compte
    public function register(Request $request)
    {
        // Valide les champs du formulaire
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:255'],
            'quartier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Veuillez saisir votre nom.',
            'email.required' => 'Veuillez saisir votre adresse email.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phone.required' => 'Veuillez saisir votre numéro de téléphone.',
            'address.required' => 'Veuillez saisir votre adresse.',
            'quartier.required' => 'Veuillez saisir votre quartier.',
            'password.required' => 'Veuillez saisir un mot de passe.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        // Crée l'utilisateur puis le connecte directement
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'quartier' => $validated['quartier'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    // Déconnecte l'utilisateur
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
