<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Modules\Mag\Models\Category;
use App\Filament\Resources\CategoryResource;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    /**
     * Define the actions available on the page.
     *
     * @return array
     */
    protected function getActions(): array
    {
        return [
            $this->createCategoryAction(),
        ];
    }

    /**
     * Create the action for creating a new category.
     *
     * @return Action
     */
    private function createCategoryAction(): Action
    {
        $locale = app()->getLocale();
        $menuTranslations = $this->getMenuTranslations($locale);
        $createName = $this->getCreateName($menuTranslations);

        return Action::make('createCategory')
            ->label($createName)
            ->modalHeading(__('create'))
            ->modalButton(__('create'))
            ->form($this->getCategoryFormSchema())
            ->action(fn(array $data) => $this->handleCreateCategory($data));
    }

    /**
     * Get the menu translations for the current locale.
     *
     * @param string $locale
     * @return array
     */
    private function getMenuTranslations(string $locale): array
    {
        return json_decode(file_get_contents(base_path("lang/{$locale}.json")), true);
    }

    /**
     * Get the translated name for the create action.
     *
     * @param array $menuTranslations
     * @return string
     */
    private function getCreateName(array $menuTranslations): string
    {
        return str_replace(':name', 'دسته بندی', $menuTranslations['createname']);
    }

    /**
     * Define the form schema for creating a new category.
     *
     * @return array
     */
    private function getCategoryFormSchema(): array
    {
        return [
            Forms\Components\Toggle::make('is_visible')
                ->label(__('visible'))
                ->default(true),

            Forms\Components\RichEditor::make('description')
                ->label(__('description'))
                ->nullable()
                ->columnSpan('full'),

            Forms\Components\TextInput::make('name')
                ->label(__('name'))
                ->unique()
                ->required(),

            Forms\Components\Select::make('parent_id')
                ->label(__('parent'))
                ->options(Category::all()->pluck('name', 'id'))
                ->nullable(),

            Forms\Components\TextInput::make('slug')
                ->label(__('slug'))
                ->unique()
                ->required(),

            Forms\Components\Select::make('order_column')
                ->label(__('order'))
                ->options(array_combine(range(1, 20), range(1, 20)))
                ->columns(2)
                ->unique()
                ->required(),

            CuratorPicker::make('image_id')
                ->label(__('image')),
        ];
    }

    /**
     * Handle the creation of a new category.
     *
     * @param array $data
     * @return void
     */
    private function handleCreateCategory(array $data): void
    {
        Category::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'slug' => $data['slug'],
            'image_id' => $data['image_id'] ?? null,
            'order_column' => $data['order_column'],
            'is_visible' => $data['is_visible'],
        ]);

        Notification::make()
            ->title(__('curator::forms.notices.success'))
            ->success()
            ->send();
    }
}
