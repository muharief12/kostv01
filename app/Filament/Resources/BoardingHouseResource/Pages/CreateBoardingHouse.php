<?php

namespace App\Filament\Resources\BoardingHouseResource\Pages;

use App\Filament\Resources\BoardingHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBoardingHouse extends CreateRecord
{
    protected static string $resource = BoardingHouseResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index resource
        return $this->getResource()::getUrl('index');
    }
}
