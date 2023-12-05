<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactUsResource\Pages;
use App\Filament\Resources\ContactUsResource\RelationManagers;
use App\Models\ContactUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactUsResource extends Resource
{
    protected static ?string $model = ContactUs::class;

    public static function getModelLabel(): string
    {
        return 'Contact Us';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Contact Us';
    }
    protected static ?string $navigationIcon = 'heroicon-o-envelope'; // Updated to a valid icon

    // protected static ?string $navigationLabel = 'Contact Us'; // Updated label

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('firstname')->label('First Name'),
                Forms\Components\TextInput::make('lastname')->label('Last Name'),
                Forms\Components\TextInput::make('email')->label('Email'),
                Forms\Components\TextInput::make('subject')->label('Subject'),
                Forms\Components\Textarea::make('message')->label('Message'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname')->label('First Name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('lastname')->label('Last Name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('subject')->label('Subject')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('message')->label('Message')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListContactUs::route('/'),
            'create' => Pages\CreateContactUs::route('/create'),
            // 'edit' => Pages\EditContactUs::route('/{record}/edit'),
            'view' => Pages\ViewContactUs::route('/{record}'),

        ];
    }
}
