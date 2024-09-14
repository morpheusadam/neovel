<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;

    public function mount(): void
    {
        parent::mount();
        // محتوای تست
        Notification::make()
            ->title('این یک پیام تست است.')
            ->success()
            ->send();
    }
}
