<?php

namespace App\Http\Controllers;

// Pages d'aide : FAQ, livraison, retours, garantie
class SupportController extends Controller
{
    // Foire aux questions
    public function faq()
    {
        return view('support.faq');
    }

    // Informations de livraison
    public function shipping()
    {
        return view('support.shipping');
    }

    // Politique de retours
    public function returns()
    {
        return view('support.returns');
    }

    // Garantie des produits
    public function warranty()
    {
        return view('support.warranty');
    }
}
