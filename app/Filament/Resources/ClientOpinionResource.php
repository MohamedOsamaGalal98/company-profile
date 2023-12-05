<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientOpinionResource\Pages;
use App\Filament\Resources\ClientOpinionResource\RelationManagers;
use App\Models\ClientOpinion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ClientOpinionResource extends Resource
{
    protected static ?string $model = ClientOpinion::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('image')->label('Image')->collection('image')->columnSpanFull(),
                Forms\Components\TextInput::make('name')->label('Name'),
                Forms\Components\TextInput::make('position')->label('Position'),
                Forms\Components\Textarea::make('opinion')->label('Opinion'),
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->options(\App\Models\Project::pluck('title', 'id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image')
                    ->label('Image')
                    ->getStateUsing(fn($record) => $record->getMedia('image')->first() ? $record->getMedia('image')->first()->getUrl() : null)
                    ->formatStateUsing(fn($state) => $state ? '<img src="' . $state . '" style="width: 50px; height: 50px; object-fit: cover;" />' : 'No image available')
                    ->html(),

                ImageColumn::make('image')
                    ->label('Images')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->getStateUsing(fn($record) => $record->getMedia('image')->map(fn($media) => $media->getUrl())->toArray()),

                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('position')->label('Position')->searchable()->sortable(),
                TextColumn::make('opinion')->label('Opinion')->searchable()->sortable(),
                TextColumn::make('project_id')->label('Project')->formatStateUsing(fn($record) => $record->project->title)->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListClientOpinions::route('/'),
            'create' => Pages\CreateClientOpinion::route('/create'),
            'edit' => Pages\EditClientOpinion::route('/{record}/edit'),
            'view' => Pages\ViewClientOpinion::route('/{record}'),
        ];
    }
}
