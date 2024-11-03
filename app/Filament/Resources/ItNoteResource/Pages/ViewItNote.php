<?php

namespace App\Filament\Resources\ItNoteResource\Pages;

use App\Filament\Resources\ItNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewItNote extends ViewRecord
{
    protected static string $resource = ItNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
