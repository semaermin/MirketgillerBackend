<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->label('Blog Başlığı'),
                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'name')->required()->label('Yayınlayan kişi'),
                Forms\Components\MarkdownEditor::make('content')->required()->label('Blog içeriği'),
                Forms\Components\FileUpload::make('image')->required()->label('Kapak Fotoğrafı')
                    ->rules([
                        'image', // Yüklenen dosyanın bir fotoğraf olması gerektiğini belirtir
                        'mimes:jpg,jpeg,png', // Yalnızca .jpg, .jpeg ve .png dosyalarına izin verilir
                    ])
                    ->disk('public') // Dosyaların kaydedileceği disk
                    ->directory('blogs'), // Hedef dizin
                Forms\Components\DateTimePicker::make('published_at')->required()->label('Etkinlik tarihi'),
                Forms\Components\Toggle::make('status')->label('Aktif mi')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable()->label('Blog Başlığı'),
                Tables\Columns\TextColumn::make('author.name')->label('Yayınlayan Kişi')->sortable()->searchable(),
                Tables\Columns\ImageColumn::make('image')->label('Kapak Fotoğrafı'),
                Tables\Columns\TextColumn::make('published_at')->label('Etkinlik Tarihi')->dateTime()->sortable(),
                Tables\Columns\IconColumn::make('status')->boolean()->label('Aktif mi')->sortable(),
            ])

            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListPost::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
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
