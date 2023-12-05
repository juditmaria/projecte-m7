<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Http\Livewire\TemporaryUploadedFile;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Crea una instancia de FileUpload para gestionar la subida de archivos en la ruta 'filepath'.
                Forms\Components\FileUpload::make('filepath')
                // Requiere que el usuario seleccione un archivo.
                ->required()
                // Establece que el archivo debe ser una imagen.
                ->image()
                // Limita el tamaño máximo del archivo a 2 megabytes.
                ->maxSize(2048)
                // Especifica que los archivos se almacenarán en el directorio 'uploads'.
                ->directory('uploads')
                // Define cómo se generará el nombre único del archivo utilizando la fecha y el nombre original.
                /* ->getUploadedFileNameForStorageUsing(function (Livewire\TemporaryUploadedFile $file): string {
                    return time() . '_' . $file->getClientOriginalName();
                }), */
                ->getUploadedFileNameForStorageUsing(function (\Illuminate\Http\UploadedFile $file): string {
                    return time() . '_' . $file->getClientOriginalName();
                }),
            /* Forms\Components\TextInput::make('filesize')
                    ->required(), */
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filepath'),
                Tables\Columns\TextColumn::make('filesize'),
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
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'view' => Pages\ViewFile::route('/{record}'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }    
}
