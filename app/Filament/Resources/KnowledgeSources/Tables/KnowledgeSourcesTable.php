<?php

namespace App\Filament\Resources\KnowledgeSources\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KnowledgeSourcesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Sumber')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('type')
                    ->label('Jenis Sumber')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'file' => 'Unggah File',
                        'text' => 'Input Teks',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'file' => 'info',
                        'text' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu Proses',
                        'processing' => 'Sedang Diproses',
                        'processed' => 'Selesai',
                        'failed' => 'Gagal',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'processed' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('creator.name')
                    ->label('Ditambahkan Oleh')
                    ->placeholder('Pengguna tidak tersedia')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Ditambahkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Jenis Sumber')
                    ->options([
                        'text' => 'Input Teks',
                        'file' => 'Unggah File',
                    ]),

                SelectFilter::make('status')
                    ->label('Status Pemrosesan')
                    ->options([
                        'pending' => 'Menunggu Proses',
                        'processing' => 'Sedang Diproses',
                        'processed' => 'Selesai',
                        'failed' => 'Gagal',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
