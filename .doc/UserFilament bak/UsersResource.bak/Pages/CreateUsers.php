<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification; // اضافه کردن این خط

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function mount(): void
    {
        parent::mount();

        $this->form->schema([
            TextInput::make('name')
                ->label('نام')
                ->required()
                ->maxLength(255),
        ]);
    }
}
