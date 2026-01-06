<?php

namespace App\Filament\Resources\ScrollTickerResource\Pages;

use App\Filament\Resources\ScrollTickerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScrollTicker extends EditRecord
{

    
    protected static string $resource = ScrollTickerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
