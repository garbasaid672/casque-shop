<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Réglage global du site (clé/valeur), ex : site_name
class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];
}
