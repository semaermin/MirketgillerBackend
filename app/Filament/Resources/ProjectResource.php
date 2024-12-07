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
                ->required(),
            Forms\Components\TextInput::make('link')
                ->url()
                ->required(),
            Forms\Components\TextInput::make('desc')
                ->required(),
            Forms\Components\FileUpload::make('image')
                ->required()
                ->image() // Yalnızca resim dosyası kabul edilir
                ->rules([
                    'dimensions:min_width=200,min_height=200,max_width=2000,max_height=2000', // Fotoğraf boyutlarını sınırlamak
                    'dimensions:ratio=1/1', // 1:1 oranı
                    // 'dimensions:ratio=3/2', // 3:2 oranı
                ])
                ->label('Image (3:2 or 1:1 Ratios)'),

            Forms\Components\Toggle::make('status')->label('Status')->default(true),
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
        return auth()->check() && auth()->user()->role === 'admin';
    }
}
