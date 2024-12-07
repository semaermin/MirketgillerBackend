<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Resources\Storage;


class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Select::make('author_id')
                ->label('Author')
                ->options(User::all()->pluck('full_name', 'id'))
                ->required(),
                Forms\Components\MarkdownEditor::make('content')->required(),
                Forms\Components\Toggle::make('status')->label('Status')->default(true),
                Forms\Components\DateTimePicker::make('published_at')->label('Published At'),
                Forms\Components\Select::make('event_type') // Etkinlik türü seçeneği
                    ->label('Event Type')
                    ->options([
                        'hackathon' => 'Hackathon',
                        'ideathon' => 'Ideathon',
                        'workshop' => 'Workshop',
                        'seminar' => 'Seminar',
                        'conference' => 'Conference',
                        'webinar' => 'Webinar',
                        'meetup' => 'Meetup',
                        'bootcamp' => 'Bootcamp',
                        'networking' => 'Networking',
                        'competition' => 'Competition',
                    ])
                    ->required(),

                Forms\Components\FileUpload::make('event_paths')
                    ->multiple() // Çoklu dosya yükleme
                    ->rules([
                        'dimensions:min_width=200,min_height=200,max_width=2000,max_height=2000', // Fotoğraf boyutlarını sınırlamak
                        'dimensions:ratio=1/1', // 1:1 oranı
                        // 'dimensions:ratio=3/2', // 3:2 oranı
                    ])
                    ->label('Etkinlik Fotoğrafları')
                    ->disk('public') // Dosyaların kaydedileceği disk
                    ->directory('events'), // Hedef dizin

            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('published_at')->label('Published At')->dateTime()->sortable(),
                Tables\Columns\IconColumn::make('status')->boolean()->label('Status')->sortable(),
                Tables\Columns\TextColumn::make('event_photos')
                ->label('Etkinlik Fotoğrafları')
                ->html()
                ->getStateUsing(function ($record) {
                    $photos = $record->event_paths; // JSON'dan dönen dizi

                    // event_paths'ın diziden oluştuğundan emin olun
                    if (is_string($photos)) {
                        $photos = json_decode($photos, true); // Eğer string ise JSON'dan çözümle
                    }

                    if (!is_array($photos)) {
                        return 'Hiç fotoğraf yok.';
                    }

                    $photoCount = count($photos); // Fotoğraf sayısını al
                    $html = '';
                    if ($photoCount === 1) {
                        $html .= '
                        <div style="width: 30px; height: 30px; overflow: hidden; border-radius: 50%; background-color: #17a2b8; display: inline-block; margin-right: 5px;">
                            <img src="' . asset('storage/' . $photos[0]) . '" alt="Etkinlik Fotoğrafı" style="width: 30px; height: 30px; object-fit: cover; display: block;">
                        </div>';
                    } else {
                        $html .= '
                        <div style="width: 30px; height: 30px; overflow: hidden; border-radius: 50%; background-color: #17a2b8; display: inline-block; margin-right: 5px;">
                            <img src="' . asset('storage/' . $photos[0]) . '" alt="Etkinlik Fotoğrafı" style="width: 30px; height: 30px; object-fit: cover; display: block;">
                        </div>';
                        // Fazladan fotoğraf sayısını göster
                        $html .= '<span style="margin-left: 5px;">+' . ($photoCount - 1) . '</span>'; // 1'den fazlası için sayıyı göster
                    }

                    return $html;
                }),

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
            'index' => Pages\ListEvent::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
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
