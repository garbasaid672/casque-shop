<?php

namespace App\Filament;

use Filament\Pages\Dashboard;
use Illuminate\Contracts\Support\Htmlable;

class AdminDashboard extends Dashboard
{
    public function getHeading(): string|Htmlable|null
    {
        return null;
    }
    //Personnaliser nombre de colonne sur dashbord admin
    public function getColumns(): int|array
    {
        return ['default' => 1, 'md' => 2];
    }
}
