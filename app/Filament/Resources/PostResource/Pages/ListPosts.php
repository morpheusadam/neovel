<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Widgets;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    /**
     * The resource model.
     */
    protected static string $resource = PostResource::class;

    /**
     * Define the header actions available on the page.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        $locale = app()->getLocale();
        $menuTranslations = $this->getMenuTranslations($locale);

        $createPostLabel = $this->getCreatePostLabel($menuTranslations);

        return [
            Actions\CreateAction::make()
                ->label($createPostLabel), // استفاده از فایل زبان برای ترجمه
        ];
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
     * Get the translated label for the create post action.
     *
     * @param array $menuTranslations
     * @return string
     */
    private function getCreatePostLabel(array $menuTranslations): string
    {
        return str_replace(':name', 'پست', $menuTranslations['createname']);
    }

    /**
     * Define the header widgets available on the page.
     *
     * @return array
     */
    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\PostOverview::class,
        ];
    }
}
