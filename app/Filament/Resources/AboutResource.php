<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Filament\Resources\AboutResource\RelationManagers;
use App\Models\About;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make('misyon') // Misyon için yeni bir alan
                    ->required()
                    ->label('Misyonumuz'),
                Forms\Components\MarkdownEditor::make('vizyon') // Vizyon için yeni bir alan
                    ->required()
                    ->label('Vizyonumuz'),
                Forms\Components\TextInput::make('ulasılankisi') // Ulaşılacak kişi için alan
                    ->required()
                    ->numeric()
                    ->label('Ulaşılan kişi'),
                Forms\Components\TextInput::make('aktifuye') // Aktif üye sayısı için alan
                    ->required()
                    ->numeric()
                    ->label('Aktif Üye'),
                Forms\Components\TextInput::make('ekipuye') // Ekip üye sayısı için alan
                    ->required()
                    ->numeric()
                    ->label('Ekip Üye'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('misyon') // Misyon alanı
                    ->sortable()
                    ->searchable()
                    ->label('Misyonumuz')
                    ->limit(20), // Metni 100 karakter ile sınırladık

                Tables\Columns\TextColumn::make('vizyon') // Vizyon alanı
                    ->sortable()
                    ->searchable()
                    ->label('Vizyonumuz')
                    ->limit(20), // Metni 100 karakter ile sınırladık

                Tables\Columns\TextColumn::make('ulasılankisi') // Ulaşılacak kişi
                    ->sortable()
                    ->searchable()
                    ->label('Ulaşılacak Kişi')
                    ->limit(50), // Metni 50 karakter ile sınırladık

                Tables\Columns\TextColumn::make('aktifuye') // Aktif üye sayısı
                    ->sortable()
                    ->label('Aktif Üye Sayısı')
                    ->formatStateUsing(fn ($state) => number_format($state)), // Sayıyı formatlamak

                Tables\Columns\TextColumn::make('ekipuye')
                    ->sortable()
                    ->label('Ekip Üye Sayısı')
                    ->formatStateUsing(fn ($state) => number_format($state)) // Sayıyı formatlamak
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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
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
