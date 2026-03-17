<?php

namespace App\Filament\Resources\PaymentTierResource\Pages;

use App\Filament\Resources\PaymentTierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentTier extends EditRecord
{
    protected static string $resource = PaymentTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
