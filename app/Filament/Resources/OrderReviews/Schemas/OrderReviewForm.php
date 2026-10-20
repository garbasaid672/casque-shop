<?php

namespace App\Filament\Resources\OrderReviews\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrderReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order.order_number')
                    ->label('Commande vérifiée')
                    ->disabled(),

                TextInput::make('author_name')
                    ->label('Client')
                    ->disabled(),

                TextInput::make('city')
                    ->label('Ville')
                    ->disabled(),

                TextInput::make('rating')
                    ->label('Note sur 5')
                    ->disabled(),

                Textarea::make('comment')
                    ->label('Avis')
                    ->rows(6)
                    ->disabled()
                    ->columnSpanFull(),

                Toggle::make('is_approved')
                    ->label('Approuver et publier cet avis')
                    ->helperText('Seuls les avis approuvés sont visibles sur la page d’accueil.'),
            ]);
    }
}
