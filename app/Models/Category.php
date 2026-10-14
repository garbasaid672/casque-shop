<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Modèle représentant une catégorie de produits (ex: Casques sans fil, Casques gaming)
class Category extends Model
{
    use HasFactory;

    // Champs autorisés pour l'assignation en masse
    protected $fillable = [
        'name',           // Nom de la catégorie
        'slug',           // URL friendly (ex: casques-sans-fil)
        'description',    // Description de la catégorie
        'image',          // Image de la catégorie (chemin stockage)
        'sort_order',     // Ordre d'affichage
        'is_active',      // Catégorie visible ou non
    ];

    // Conversion automatique des types
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relation : une catégorie a plusieurs produits
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Image affichée : image catégorie si définie, sinon première image du
    // produit actif le plus récent (jamais de carte vide).
    public function getDisplayImageAttribute(): ?string
    {
        if ($this->image) {
            return $this->image;
        }

        $product = $this->products()
            ->where('is_active', true)
            ->latest('published_at')
            ->first();

        return $product?->images[0] ?? null;
    }
}