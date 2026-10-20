<?php

namespace App\Filament\Resources\KnowledgeSources\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KnowledgeSourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sumber Data')
                    ->description('Tambahkan dokumen atau informasi yang akan digunakan oleh AI Agent.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Sumber')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Jenis Sumber')
                            ->options([
                                'text' => 'Input Teks',
                                'file' => 'Unggah File',
                            ])
                            ->required()
                            ->live()
                            ->default('text'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('content')
                            ->label('Isi Informasi')
                            ->helperText('Masukkan informasi yang ingin dijadikan sumber data AI.')
                            ->rows(8)
                            ->required(fn ($get): bool => $get('type') === 'text')
                            ->visible(fn ($get): bool => $get('type') === 'text')
                            ->columnSpanFull(),

                        FileUpload::make('file_path')
                            ->label('Pilih File')
                            ->helperText('Unggah dokumen sumber pengetahuan. File disimpan di penyimpanan aplikasi.')
                            ->disk('local')
                            ->directory('knowledge-sources')
                            ->visibility('private')
                            ->acceptedFileTypes([
                                'text/plain',
                                'text/csv',
                                'application/pdf',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-excel',
                            ])
                            ->maxSize(10240)
                            ->required(fn ($get): bool => $get('type') === 'file')
                            ->visible(fn ($get): bool => $get('type') === 'file')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
