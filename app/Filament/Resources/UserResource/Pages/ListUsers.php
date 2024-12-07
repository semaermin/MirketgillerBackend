<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    /**
     * Kullanıcı rolünü kontrol et.
     */
    public function mount(): void
    {
        parent::mount();

        $user = Auth::user();

        // Eğer kullanıcı admin değilse, ana sayfaya yönlendir
        if (!$user || $user->role !== 'super admin') {
            redirect('/error');
        }
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
