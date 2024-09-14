<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms;
use Filament\Tables\Columns\TextColumn;
use Modules\CMS\Models\Category;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('description') // اضافه کردن تکست اینپوت جدید
                ->label('Description')
                ->maxLength(500),
            Select::make('parent_id') // اضافه کردن فیلد انتخاب والد
                ->label(' دسته مادر')
                ->options(function () {
                    return Category::where('id', '!=', $this->record->id)
                        ->pluck('name', 'id');
                })
                ->nullable(),
            TextInput::make('slug') // اضافه کردن فیلد slug
                ->label('Slug')
                ->required()
                ->maxLength(255),
        ]);
    }

    protected function getTableQuery()
    {
        return Category::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Name')
                ->sortable()
                ->searchable(),
            TextColumn::make('description')
                ->label('Description')
                ->sortable()
                ->searchable(),
            TextColumn::make('parent.name')
                ->label('Parent Category')
                ->sortable()
                ->searchable(),
            TextColumn::make('slug')
                ->label('Slug')
                ->sortable()
                ->searchable(),
        ];
    }
}
