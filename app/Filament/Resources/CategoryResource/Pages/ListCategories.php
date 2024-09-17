<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Awcodes\Curator\Components\Tables\CuratorColumn;
use Modules\CMM\Models\Category;
use App\Filament\Resources\CategoryResource;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\Action;
use Filament\Forms;
use Illuminate\Database\QueryException;
use Filament\Notifications\Notification;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            url('/admin/categories') => 'Category Management',
        ];
    }

    public function getTitle(): string
    {
        return 'Category Management';
    }

    protected function getActions(): array
    {
        return [
            $this->createCategoryAction(),
            $this->createPostAction(), // اضافه کردن اکشن ساخت پست
        ];
    }

    private function createCategoryAction(): Action
    {
        return Action::make('createCategory')
            ->label('Create New Category')
            ->modalHeading('Create New Category')
            ->modalButton('Create')
            ->form($this->getCategoryForm())
            ->action(fn(array $data) => $this->handleCreateCategory($data));
    }

    private function createPostAction(): Action
    {
        return Action::make('createPost')
            ->label('ساخت پست')
            ->url('/admin/posts/create') // لینک به صفحه ساخت پست
            ->color('primary');
    }

    private function getCategoryForm(): array
    {
        return [
            Forms\Components\Toggle::make('is_visible')
            ->label('Visible')
            ->default(true),

        Forms\Components\RichEditor::make('description') // تغییر از Textarea به RichEditor
            ->label('Description')
            ->nullable()
            ->columnSpan('full'), // تنظیم به صورت تمام صفحه

        Forms\Components\TextInput::make('name')
            ->label('Name')
            ->required(),

        Forms\Components\Select::make('parent_id')
            ->label('Parent Category')
            ->options(Category::all()->pluck('name', 'id'))
            ->nullable(),

        Forms\Components\TextInput::make('slug')
            ->label('Slug')
            ->required(),

        Forms\Components\Select::make('order_column') // تغییر از CheckboxList به Select
            ->label('Order')
            ->options(array_combine(range(1, 20), range(1, 20)))
            ->columns(2) // دو ستون افقی
            ->required(),

            CuratorPicker::make('image')
            ->required(),
        ];
    }

    private function handleCreateCategory(array $data): void
    {
        try {
            Category::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'parent_id' => $data['parent_id'] ?? null,
                'slug' => $data['slug'],
                'image_path' => $data['image_path'] ?? null,
                'order_column' => $data['order_column'],
                'is_visible' => $data['is_visible'],
            ]);

            Notification::make()
                ->title('Success')
                ->body('Category created successfully.')
                ->success()
                ->send();
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                Notification::make()
                    ->title('Error')
                    ->body('Category already exists.')
                    ->danger()
                    ->send();
            } else {
                Notification::make()
                    ->title('Error')
                    ->body('An error occurred: ' . $e->getMessage())
                    ->danger()
                    ->send();
            }
        }
    }
}
