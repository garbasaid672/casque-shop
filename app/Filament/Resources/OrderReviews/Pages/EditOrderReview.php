<?php

namespace App\Filament\Resources\OrderReviews\Pages;

use App\Filament\Resources\OrderReviews\OrderReviewResource;
use Filament\Resources\Pages\EditRecord;

class EditOrderReview extends EditRecord
{
    protected static string $resource = OrderReviewResource::class;
}
