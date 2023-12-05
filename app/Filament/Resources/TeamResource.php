<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
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


class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('image')->label('Image')->collection('image')->columnSpanFull(),
                Forms\Components\TextInput::make('firstname')->label('First Name'),
                Forms\Components\TextInput::make('lastname')->label('Last Name'),
                Forms\Components\TextInput::make('position')->label('Position'),
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

                TextColumn::make('firstname')->label('First Name')->searchable()->sortable(),
                TextColumn::make('lastname')->label('Last Name')->searchable()->sortable(),
                TextColumn::make('position')->label('Position')->searchable()->sortable(),
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
            'view' => Pages\ViewTeam::route('/{record}'),
        ];
    }
}
