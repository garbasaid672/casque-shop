<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Message envoyé depuis le formulaire de contact
class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
