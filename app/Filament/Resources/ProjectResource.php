<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\ImageColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // SpatieMediaLibraryFileUpload::make('image')->label('Image')->collection('image')->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Images')
                    ->collection('images')
                    ->multiple()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('title')->label('Title')->required(),
                TextInput::make('description')->label('Description')->required(),
                TextInput::make('category')
                    ->label('Category')
                    ->datalist([
                        'website' => 'Website',
                        'android' => 'android',
                        'ios' => 'ios',
                    ])
                    ->required()
                    ->rule('in:Website,android,ios'),
                TextInput::make('client_name')->label('Client Name')->required(),
                TextInput::make('demo_email')->email()->nullable()->label('Demo Email'),
                TextInput::make('demo_password')->password()->revealable()->nullable()->label('Demo Password'),
                TextInput::make('demo_link')->nullable()->label('Demo Link'),
                TextInput::make('dashboard_email')->email()->nullable()->label('Dashboard Email'),
                TextInput::make('dashboard_password')->password()->revealable()->nullable()->label('Dashboard Password'),
                TextInput::make('dashboard_link')->nullable()->label('Dashboard Link'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('image')
                //     ->label('Image')
                //     ->getStateUsing(fn($record) => $record->getFirstMediaUrl('image'))
                //     ->formatStateUsing(fn($state) => $state ? '<img src="' . $state . '" style="width: 50px; height: 50px; object-fit: cover;" />' : 'No image available') // Use the state directly
                //     ->html(),

                TextColumn::make('images')
                    ->label('Images')
                    ->getStateUsing(fn($record) => $record->getMedia('images'))
                    ->formatStateUsing(function ($record) {
                        return $record->getImages()->map(fn($media) => '<img src="' . $media->getUrl() . '" style="width: 50px; height: 50px; margin-bottom: 20px; object-fit: cover; margin-right: 5px;" />')->join('');
                    })
                    ->html(),

                ImageColumn::make('images')
                    ->label('Images')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->getStateUsing(fn($record) => $record->getMedia('images')->map(fn($media) => $media->getUrl())->toArray()),



                TextColumn::make('title')->label('Title')->searchable()->sortable(),
                TextColumn::make('description')->label('Description')->searchable()->sortable(),
                TextColumn::make('category')->label('Category')->searchable()->sortable(),
                TextColumn::make('client_name')->label('Client Name')->searchable()->sortable(),
                TextColumn::make('demo_email')->label('Demo Email')->searchable()->sortable(),
                TextColumn::make('demo_password')->label('Demo Password')->searchable()->sortable(),
                TextColumn::make('demo_link')->label('Demo Link')->searchable()->sortable(),
                TextColumn::make('dashboard_email')->label('Dashboard Email')->searchable()->sortable(),
                TextColumn::make('dashboard_password')->label('Dashboard Password')->searchable()->sortable(),
                TextColumn::make('dashboard_link')->label('Dashboard Link')->searchable()->sortable(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            'view' => Pages\ViewProject::route('/{record}'),
        ];
    }

    // public static function getTableColumns(): array
    // {
    //     return [
    //         ImageColumn::make('colleagues.avatar')
    //             ->circular() // Display images in a circle
    //             ->stacked()  // Stack multiple images
    //             ->limit(3)   // Show only 3 images
    //             ->limitedRemainingText(), // Show remaining images count
    //     ];
    // }
}
