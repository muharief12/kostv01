<?php

namespace App\Filament\Resources\BoardingHouseResource\Pages;

use App\Filament\Resources\BoardingHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBoardingHouse extends EditRecord
{
    protected static string $resource = BoardingHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index resource
        return $this->getResource()::getUrl('index');
    }
}
