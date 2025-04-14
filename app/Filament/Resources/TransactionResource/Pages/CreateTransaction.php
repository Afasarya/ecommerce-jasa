<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Transaction;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['transaction_id'])) {
            $data['transaction_id'] = Transaction::generateTransactionId();
        }
        
        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}