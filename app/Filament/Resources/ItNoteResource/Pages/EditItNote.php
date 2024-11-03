<?php

namespace App\Filament\Resources\ItNoteResource\Pages;

use App\Filament\Resources\ItNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItNote extends EditRecord
{
    protected static string $resource = ItNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
