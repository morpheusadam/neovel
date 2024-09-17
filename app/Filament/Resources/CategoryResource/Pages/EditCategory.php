<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms; // اضافه کردن این خط برای استفاده از Forms
use Modules\CMM\Models\Category;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Forms\Form $form): Forms\Form // اصلاح نوع‌دهی به Forms\Form
    {
        return $form->schema([
            Forms\Components\Toggle::make('is_visible')
                ->label('نمایش')
                ->default(fn($record) => $record->is_visible),

            Forms\Components\RichEditor::make('description') // تغییر از Textarea به RichEditor
                ->label('توضیحات')
                ->default(fn($record) => $record->description)
                ->columnSpan('full'), // تنظیم به صورت تمام صفحه
                Forms\Components\TextInput::make('name')
                ->label('نام')
                ->maxLength(255)
                ->default(fn($record) => $record->name),


            Forms\Components\Select::make('parent_id')
                ->label('دسته والد')
                ->options(options: Category::all()->pluck('name', 'id'))
                ->default(fn($record) => $record->parent_id),

            Forms\Components\TextInput::make('slug')
                ->label('نامک')
                ->default(fn($record) => $record->slug),

            Forms\Components\Select::make('order_column') // تغییر از CheckboxList به Select
                ->label('ترتیب')
                ->options(array_combine(range(1, 20), range(1, 20)))
                ->columns(2) // دو ستون افقی
                ->default(fn($record) => $record->order_column),
                CuratorColumn::make('image')
                    ->circular()
                    ->size(32),



        ]);
    }
}
