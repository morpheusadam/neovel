<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Modules\CMM\Models\Category;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use TomatoPHP\FilamentMediaManager\Form\MediaManagerInput;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string
    {
        return 'ایجاد دسته جدید';
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('is_visible')
                    ->label('Visible')
                    ->default(true),

                Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    ->columnSpan('full'),

                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->unique(Category::class, 'name', fn($record) => $record),


                Forms\Components\Select::make('parent_id')
                    ->label('Parent Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->nullable(),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(Category::class, 'slug', fn($record) => $record),

                Forms\Components\Select::make('order_column')
                    ->label('Order')
                    ->options(array_combine(range(1, 20), range(1, 20)))
                    ->columns(2)
                    ->required(),

                    CuratorPicker::make('image')
                    ->circular()
                    ->size(32),


            ]);
    }

    // protected function handleRecordCreation(array $data): ?Notification
    // {
    //     try {
    //         return parent::handleRecordCreation($data);
    //     } catch (QueryException $exception) {
    //         if ($exception->errorInfo[1] == 1062) {
    //             throw ValidationException::withMessages([
    //                 'slug' => 'The slug must be unique.',
    //             ]);
    //         }

    //         throw $exception;
    //     }
    // }
}
