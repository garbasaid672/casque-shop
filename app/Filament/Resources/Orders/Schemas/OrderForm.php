<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Filament\Resources\Orders\Tables\OrdersTable;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')
                    ->label('Statut')
                    ->required()
                    ->options(OrdersTable::STATUS_LABELS),

                Select::make('payment_status')
                    ->label('Statut du paiement')
                    ->required()
                    ->options(OrdersTable::PAYMENT_LABELS),

                Select::make('payment_method')
                    ->label('Moyen de paiement')
                    ->options([
                        'kkiapay' => 'En ligne (KkiaPay)',
                        'mobile_money' => 'Mobile Money',
                        'cash_on_delivery' => 'À la livraison',
                    ]),

                TextInput::make('payment_reference')
                    ->label('Référence de paiement')
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email client')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Téléphone client')
                    ->tel()
                    ->maxLength(30),

                TextInput::make('billing_first_name')
                    ->label('Prénom (facturation)')
                    ->required()
                    ->maxLength(255),

                TextInput::make('billing_last_name')
                    ->label('Nom (facturation)')
                    ->required()
                    ->maxLength(255),

                TextInput::make('billing_address')
                    ->label('Adresse (facturation)')
                    ->required()
                    ->maxLength(255),

                TextInput::make('billing_city')
                    ->label('Ville (facturation)')
                    ->required()
                    ->maxLength(255),

                TextInput::make('billing_country')
                    ->label('Pays (facturation)')
                    ->required()
                    ->maxLength(255),

                TextInput::make('billing_phone')
                    ->label('Téléphone (facturation)')
                    ->tel()
                    ->maxLength(30),

                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
