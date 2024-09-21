<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Modules\Mag\Models\Category;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    /**
     * Get the title for the create category page.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return __('create_category');
    }

    /**
     * Define the form schema for creating a category.
     *
     * @param Forms\Form $form
     * @return Forms\Form
     */
    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema($this->getFormSchema());
    }

    /**
     * Get the form schema for creating a category.
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Toggle::make('is_visible')
                ->label(__('visible'))
                ->default(true),

            Forms\Components\RichEditor::make('description')
                ->label(__('description'))
                ->columnSpan('full'),

            Forms\Components\TextInput::make('name')
                ->label(__('name'))
                ->required()
                ->unique(Category::class, 'name', fn($record) => $record),

            Forms\Components\Select::make('parent_id')
                ->label(__('parent'))
                ->options(Category::all()->pluck('name', 'id'))
                ->nullable(),

            Forms\Components\TextInput::make('slug')
                ->label(__('slug'))
                ->required()
                ->unique(Category::class, 'slug', fn($record) => $record),

            Forms\Components\Select::make('order_column')
                ->label(__('order'))
                ->options(array_combine(range(1, 20), range(1, 20)))
                ->columns(2)
                ->required(),

            CuratorPicker::make('image_id')
                ->label(__('image'))
                ->circular()
                ->size(32),
        ];
    }
}
