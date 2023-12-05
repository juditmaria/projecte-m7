<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Filament\Resources\PlaceResource\RelationManagers;
use App\Models\Place;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Facades\Auth;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('file_id')
                    ->required(),
                Forms\Components\Select::make('author_id')
                    ->relationship('user', 'name')
                    ->label('Author')
                    ->required()
                    ->default(Auth::id()),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->required(),
                Forms\Components\TextInput::make('latitude')
                    ->required(),
                Forms\Components\TextInput::make('longitude')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_id'),
                Tables\Columns\TextColumn::make('author_id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('latitude'),
                Tables\Columns\TextColumn::make('longitude'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePlaces::route('/'),
        ];
    }    
}
