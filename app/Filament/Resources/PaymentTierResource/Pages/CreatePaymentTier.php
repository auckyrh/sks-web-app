<?php

namespace App\Filament\Resources\PaymentTierResource\Pages;

use App\Filament\Resources\PaymentTierResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentTier extends CreateRecord
{
    protected static string $resource = PaymentTierResource::class;
}
