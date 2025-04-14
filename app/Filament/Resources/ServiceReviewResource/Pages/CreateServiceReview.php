<?php

namespace App\Filament\Resources\ServiceReviewResource\Pages;

use App\Filament\Resources\ServiceReviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceReview extends CreateRecord
{
    protected static string $resource = ServiceReviewResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}