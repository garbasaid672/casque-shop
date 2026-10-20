<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Mail\OrderDeliveredReviewInvitation;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected ?string $previousStatus = null;

    protected function beforeSave(): void
    {
        $this->previousStatus = $this->record->status;
    }

    protected function afterSave(): void
    {
        if (($this->previousStatus === 'delivered') || ($this->record->status !== 'delivered')) {
            return;
        }

        try {
            Mail::to($this->record->email)->send(new OrderDeliveredReviewInvitation($this->record));
        } catch (\Throwable $exception) {
            Log::warning('Invitation à laisser un avis non envoyée', [
                'order' => $this->record->order_number,
                'error' => $exception->getMessage(),
            ]);

            Notification::make()
                ->warning()
                ->title('La commande est livrée, mais l’invitation à laisser un avis n’a pas été envoyée.')
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
