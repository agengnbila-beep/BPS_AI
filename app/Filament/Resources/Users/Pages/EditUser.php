<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var User $record */
        $record = $this->getRecord();

        if (
            $record->isLastAdmin()
            && ($data['role'] ?? $record->role) !== 'admin'
        ) {
            Notification::make()
                ->danger()
                ->title('Role admin terakhir tidak dapat diubah')
                ->body('Tetapkan admin lain terlebih dahulu sebelum mengubah role akun ini.')
                ->send();

            throw new Halt();
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function (DeleteAction $action, Model $record): void {
                    if ($record instanceof User && $record->isLastAdmin()) {
                        Notification::make()
                            ->danger()
                            ->title('Admin terakhir tidak dapat dihapus')
                            ->body('Buat admin pengganti terlebih dahulu.')
                            ->send();

                        $action->cancel();
                    }
                }),
        ];
    }
}