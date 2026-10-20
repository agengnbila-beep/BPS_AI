<?php

namespace App\Filament\Resources\KnowledgeSources\Pages;

use App\Filament\Resources\KnowledgeSources\KnowledgeSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgeSource extends EditRecord
{
    protected static string $resource = KnowledgeSourceResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['status'] = 'pending';
        $data['processing_error'] = null;
        $data['processed_at'] = null;

        if (($data['type'] ?? null) === 'text') {
            $data['file_path'] = null;
            $data['original_filename'] = null;
            $data['mime_type'] = null;
            $data['file_size'] = null;
        } else {
            $data['content'] = null;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
