<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
        CreateAction::make()
                ->label('ایجاد دسته‌بندی') // تغییر نام دکمه
                ->modalHeading('ایجاد دسته‌بندی جدید') // عنوان پاپ آپ
                ->modalButton('ایجاد') // دکمه پاپ آپ
                ->form([
                    TextInput::make('name')
                        ->label('نام دسته‌بندی')
                        ->required(),
                    TextInput::make('description')
                        ->label('توضیحات')
                        ->required(),
                ]),
        ];
    }
}
