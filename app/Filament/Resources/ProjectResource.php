<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()->label('Proje Adı'),
            Forms\Components\TextInput::make('link')
                ->url()
                ->required()->label('Projenin olduğu link url adresi'),
            Forms\Components\TextInput::make('desc')
                ->required()->label('Proje Açıklaması'),
            Forms\Components\FileUpload::make('image')
                ->required()
                ->label('Kapak Fotoğrafı')
                ->image() // Yalnızca resim dosyası kabul edilir
                ->rules([
                    'image', // Yüklenen dosyanın bir fotoğraf olması gerektiğini belirtir
                    'mimes:jpg,jpeg,png', // Yalnızca .jpg, .jpeg ve .png dosyalarına izin verilir
                ])
                ->disk('public') // Dosyaların kaydedileceği disk
                ->directory('projects'), // Hedef dizin
            Forms\Components\Toggle::make('status')->label('Aktif mi')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('link'),
                // Tables\Columns\TextColumn::make('desc'),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\IconColumn::make('status')->boolean()->label('Status')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    /**
     * Navigation görünürlüğünü kontrol eder.
     */
    protected static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return auth()->check() && (
            $user->role === 'admin' ||
            $user->role === 'blog admin'
        );
    }
}
