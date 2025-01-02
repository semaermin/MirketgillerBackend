<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\RelationManagers;
use App\Models\Partner;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->required()->label('Şirket Adı'),
                Forms\Components\TextInput::make('logo_url')
                    ->url() // Logo URL'si için 'email' yerine 'url' doğrulaması
                    ->required()->label('Şirketin Logo Urlsi'),
                Forms\Components\TextInput::make('alt_text')
                    ->required()
                    ->label('Alt Açıklama'),
                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->label('Şirketin Logo Fotosu')
                    ->disk('public') // Dosyaların kaydedileceği disk
                    ->directory('partners'), // Hedef dizin
                Forms\Components\Toggle::make('status')->label('Aktif mi')->default(true),
                Forms\Components\Select::make('partner_type') // Partner tipini seçmek için
                    ->label('Şirket Tipi')
                    ->options([
                        'sponsor' => 'Sponsor',
                        'supporter' => 'Destekçi',
                    ])
                    ->required()
                    ->default('sponsor'), // Varsayılan değer
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name'),
                Tables\Columns\TextColumn::make('logo_url'),
                Tables\Columns\TextColumn::make('alt_text'),
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }

    /**
     * Navigation görünürlüğünü kontrol eder.
     */
    protected static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return auth()->check() && (
            $user->role === 'admin'
        );
    }
}
