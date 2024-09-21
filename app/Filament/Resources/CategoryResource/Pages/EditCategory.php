<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Modules\Mag\Models\Category;
use Awcodes\Curator\Components\Forms\CuratorPicker;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    /**
     * Define the header actions available on the page.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Define the form schema for editing a category.
     *
     * @param Forms\Form $form
     * @return Forms\Form
     */
    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema($this->getFormSchema());
    }

    /**
     * Get the form schema for editing a category.
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Toggle::make('is_visible')
                ->label(__('view'))
                ->default(fn($record) => $record->is_visible),

            Forms\Components\RichEditor::make('description')
                ->label(__('description'))
                ->default(fn($record) => $record->description)
                ->columnSpan('full'),

            Forms\Components\TextInput::make('name')
                ->label(__('name'))
                ->maxLength(255)
                ->default(fn($record) => $record->name),

            Forms\Components\Select::make('parent_id')
                ->label(__('parent'))
                ->options(Category::all()->pluck('name', 'id'))
                ->default(fn($record) => $record->parent_id),

            Forms\Components\TextInput::make('slug')
                ->label(__('slug'))
                ->default(fn($record) => $record->slug),

            Forms\Components\Select::make('order_column')
                ->label(__('order'))
                ->options(array_combine(range(1, 20), range(1, 20)))
                ->columns(2)
                ->default(fn($record) => $record->order_column),

            CuratorPicker::make('image_id')
                ->label(__('image')),
        ];
    }
}
