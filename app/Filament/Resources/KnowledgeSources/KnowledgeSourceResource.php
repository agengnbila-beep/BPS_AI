<?php

namespace App\Filament\Resources\KnowledgeSources;

use App\Filament\Resources\KnowledgeSources\Pages\CreateKnowledgeSource;
use App\Filament\Resources\KnowledgeSources\Pages\EditKnowledgeSource;
use App\Filament\Resources\KnowledgeSources\Pages\ListKnowledgeSources;
use App\Filament\Resources\KnowledgeSources\Schemas\KnowledgeSourceForm;
use App\Filament\Resources\KnowledgeSources\Tables\KnowledgeSourcesTable;
use App\Models\KnowledgeSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KnowledgeSourceResource extends Resource
{
    protected static ?string $model = KnowledgeSource::class;

    protected static ?string $navigationLabel = 'Sumber  Data';

    protected static ?string $modelLabel = 'Sumber  Data';

    protected static ?string $pluralModelLabel = 'Sumber  Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCircleStack;
    
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return KnowledgeSourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KnowledgeSourcesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKnowledgeSources::route('/'),
            'create' => CreateKnowledgeSource::route('/create'),
            'edit' => EditKnowledgeSource::route('/{record}/edit'),
        ];
    }
}
