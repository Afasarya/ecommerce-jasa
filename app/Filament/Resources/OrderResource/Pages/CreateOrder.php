<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Order;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['order_number'] = Order::generateOrderNumber();
        
        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}