<?php

// app/Filament/Resources/EventResource/Pages/EditEvent.php
namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function afterUpdate(): void
    {
        if (request()->hasFile('event_paths')) {
            $paths = $this->getEventPaths(); // Yüklenen dosya yollarını al
            $this->record->event_paths = json_encode($paths); // Yüklenen dosya yollarını JSON olarak güncelle
            $this->record->save();
        }
    }

    private function getEventPaths(): array
    {
        $paths = []; // Boş bir dizi oluştur

        // Dosyaları yükle
        foreach (request()->file('event_paths') as $file) {
            $path = $file->store('events'); // Dosyayı kaydet
            $paths[] = $path; // Yolu diziye ekle
        }

        return $paths; // Yüklenen dosya yollarını döndür
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
