<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Modèle représentant un produit (casque audio)
class Product extends Model
{
    use HasFactory;

    // Champs autorisés pour l'assignation en masse
    protected $fillable = [
        'category_id',        // ID de la catégorie parente
        'name',               // Nom du produit
        'slug',               // URL friendly (ex: sony-wh-1000xm5)
        'description',        // Description complète
        'short_description',  // Description courte pour les listings
        'price',              // Prix actuel
        'compare_at_price',   // Prix barré (pour promo)
        'sku',                // Référence unique (ex: SKU-ABC12345)
        'stock_quantity',     // Quantité en stock
        'low_stock_threshold',// Seuil d'alerte stock bas
        'images',             // Tableau d'images (JSON)
        'brand',              // Marque (Sony, Bose, etc.)
        'model',              // Référence modèle constructeur
        'color',              // Couleur
        'specifications',     // Spécifications techniques (JSON)
        'features',           // Liste des fonctionnalités (JSON)
        'is_active',          // Produit visible en boutique
        'is_featured',        // Produit mis en avant (page d'accueil)
        'published_at',       // Date de publication
    ];

    // Conversion automatique des types
    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'images' => 'array',
        'specifications' => 'array',
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relation : un produit appartient à une catégorie
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relation : un produit peut avoir plusieurs lignes de commande
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Taux de conversion euro -> franc CFA pour l'affichage boutique
    public const FCFA_RATE = 650;

    // Accesseur : prix formaté en FCFA (ex : 42 250 FCFA)
    public function getPriceFcfaAttribute(): string
    {
        return number_format((int) round($this->price * self::FCFA_RATE), 0, ',', ' ') . ' FCFA';
    }

    // Accesseur : prix barré formaté en FCFA (ou null si absent)
    public function getCompareAtPriceFcfaAttribute(): ?string
    {
        if (! $this->compare_at_price) {
            return null;
        }

        return number_format((int) round($this->compare_at_price * self::FCFA_RATE), 0, ',', ' ') . ' FCFA';
    }

    // Accesseur : vérifie si le stock est bas
    public function getIsLowStockAttribute(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    // Accesseur : calcule le pourcentage de réduction si prix barré > prix actuel
    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->compare_at_price && $this->compare_at_price > $this->price) {
            return round((($this->compare_at_price - $this->price) / $this->compare_at_price) * 100);
        }
        return null;
    }
}