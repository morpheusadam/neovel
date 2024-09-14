<?php

namespace App\Filament\Resources\PostsResource\Pages;

use App\Filament\Resources\PostsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Mail;
use Modules\CMS\Models\Post;

class ListPosts extends ListRecords
{
    protected static string $resource = PostsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('ایجاد محتوا'), // تغییر متن دکمه
            Actions\Action::make('sendWelcomeEmail')
            ->label('ارسال ایمیل خوش‌آمدگویی')
            ->action(function (Post $record) {
                Mail::raw('خوش آمدید به سیستم ما!', function ($message) use ($record) {
                    $message->to($record->email)
                            ->subject('ایمیل خوش‌آمدگویی');
                });
            })
            ->requiresConfirmation()
            ->modalHeading('ارسال ایمیل خوش‌آمدگویی')
            ->modalSubheading('آیا مطمئن هستید که می‌خواهید این ایمیل را ارسال کنید؟')
            ->icon('heroicon-o-envelope') // تغییر آیکون به یک آیکون موجود
            ->color('success'),  // ... سایر اکشن‌ها ...
        ];
    }

    protected function getTableColumns(): array
    {
        return [
        ];
    }
}
