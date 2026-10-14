<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->disabled(),

                TextInput::make('email')
                    ->label('Email')
                    ->disabled(),

                TextInput::make('phone')
                    ->label('Téléphone')
                    ->disabled(),

                TextInput::make('subject')
                    ->label('Sujet')
                    ->disabled()
                    ->columnSpanFull(),

                Textarea::make('message')
                    ->label('Message')
                    ->rows(6)
                    ->disabled()
                    ->columnSpanFull(),

                Toggle::make('is_read')
                    ->label('Marquer comme lu')
                    ->default(false),
            ]);
    }
}
