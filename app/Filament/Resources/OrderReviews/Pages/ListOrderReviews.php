<?php

namespace App\Filament\Resources\OrderReviews\Pages;

use App\Filament\Resources\OrderReviews\OrderReviewResource;
use Filament\Resources\Pages\ListRecords;

class ListOrderReviews extends ListRecords
{
    protected static string $resource = OrderReviewResource::class;
}
