<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ListUsers extends ListRecords
{
    protected static string $resource = UsersResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('ایجاد کاربر'), // تغییر متن دکمه
            Actions\Action::make('sendWelcomeEmail')
                ->label('ارسال ایمیل خوش‌آمدگویی')
                ->action(function (User $record) {
                    Mail::raw('خوش آمدید به سیستم ما!', function ($message) use ($record) {
                        $message->to($record->email)
                                ->subject('ایمیل خوش‌آمدگویی');
                    });
                })
                ->requiresConfirmation()
                ->modalHeading('ارسال ایمیل خوش‌آمدگویی')
                ->modalSubheading('آیا مطمئن هستید که می‌خواهید این ایمیل را ارسال کنید؟')
                ->icon('heroicon-o-envelope') // تغییر آیکون به یک آیکون موجود
                ->color('success'),
        ];
    }
}
