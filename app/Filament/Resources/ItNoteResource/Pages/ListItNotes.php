<?php

namespace App\Filament\Resources\ItNoteResource\Pages;

use App\Filament\Resources\ItNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItNotes extends ListRecords
{
    protected static string $resource = ItNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
