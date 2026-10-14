<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

// Page contact : coordonnées + formulaire de message
class ContactController extends Controller
{
    // Affiche la page contact
    public function show()
    {
        return view('contact');
    }

    // Enregistre le message du formulaire
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'Veuillez saisir votre nom.',
            'email.required' => 'Veuillez saisir votre adresse email.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'subject.required' => 'Veuillez saisir un sujet.',
            'message.required' => 'Veuillez écrire votre message.',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Message envoyé ! Nous vous répondrons très vite.');
    }
}
