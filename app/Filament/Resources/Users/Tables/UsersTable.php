<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
           ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                    ->accessSelectedRecords()
                    ->before(function (DeleteBulkAction $action): void {
                            $records = $action->getSelectedRecords();

                            $containsLastAdmin = $records->contains(
                                fn ($record): bool => $record instanceof User
                                    && $record->isLastAdmin(),
                            );

                            if ($containsLastAdmin) {
                                Notification::make()
                                    ->danger()
                                    ->title('Penghapusan dibatalkan')
                                    ->body('Admin terakhir tidak dapat dihapus. Pilih akun lain atau tetapkan admin pengganti terlebih dahulu.')
                                    ->send();

                                $action->cancel();
                            }
                        }),
                ]),
            ]);
    }
}