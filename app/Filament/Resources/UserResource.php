<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('surname')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('password')
                ->password()
                ->required()
                ->label('Password')
                ->rule(Password::defaults()),
                Forms\Components\TextInput::make('password_confirmation') // Şifreyi doğrulamak için
                ->password()
                ->required()
                ->label('Confirm Password')
                ->same('password'),
                Forms\Components\Select::make('role')
                    ->options([
                        'blog admin' => 'blog',
                        'normal' => 'admin',
                    ])
                    ->default('normal') // Varsayılan olarak "user"
                    ->required()
                    ->label('Role'),
                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->rules([
                        'image', // Yüklenen dosyanın bir fotoğraf olması gerektiğini belirtir
                        'mimes:jpg,jpeg,png', // Yalnızca .jpg, .jpeg ve .png dosyalarına izin verilir
                    ])
                    ->disk('public') // Dosyaların kaydedileceği disk
                    ->directory('users'), // Hedef dizin
                Forms\Components\Select::make('departman_id')
                    ->relationship('department', 'name') // İlişkiyi belirtir
                    ->required()
                    ->label('Department')
                    ->placeholder('Select a Department'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('role')->label('Role'),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\SelectFilter::make('role')
                ->options([
                    'super admin' => 'Super Admin',
                    'blog admin' => 'Blog Admin',
                    'user' => 'User',
                ]),

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
