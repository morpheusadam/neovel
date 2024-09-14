<?php

namespace App\Filament\Resources\PostsResource\Pages;

use App\Filament\Resources\PostsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePosts extends CreateRecord
{
    protected static string $resource = PostsResource::class;

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
