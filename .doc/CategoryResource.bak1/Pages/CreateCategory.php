<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms;
use Filament\Tables\Columns\TextColumn;
use Filament\Pages\Actions;
use Modules\CMS\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    public bool $saveAndCreateNext = false;

    public function mount(): void
    {
        parent::mount();

        // محتوای تست
        Notification::make()
            ->title('این یک پیام تست است.')
            ->success()
            ->send();
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('slug') // اضافه کردن فیلد slug
                ->label('Slug')
                ->required()
                ->maxLength(255),
            RichEditor::make('description') // تغییر به ویرایشگر متن حرفه‌ای
                ->label('Description')
                ->maxLength(500)
                ->columnSpan('full'), // تنظیم عرض کامل
            Select::make('parent_id') // اضافه کردن فیلد انتخاب والد
                ->label(' دسته مادر')
                ->relationship('parent', 'name')
                ->nullable(),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // اطمینان از مقداردهی فیلد slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // اطمینان از یکتا بودن فیلد slug
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        return $data;
    }

    public function create(bool $another = false): void
    {
        try {
            parent::create($another);
        } catch (QueryException $exception) {
            Notification::make()
                ->title('خطا')
                ->body('دسته‌بندی یا اسلاگ تکراری است.')
                ->danger()
                ->send();
        }
    }

    protected function afterCreate(): void
    {
        if ($this->saveAndCreateNext) {
            // ریست کردن فرم برای ایجاد دسته‌بندی جدید
            $this->fillForm();
            $this->saveAndCreateNext = false;
        } else {
            // هدایت کاربر به صفحه دسته‌بندی‌ها
            $this->redirect($this->getResource()::getUrl('index'));
        }
    }

    protected function getActions(): array
    {
        return [
       
        ];
    }

    public function saveAndCreateNext()
    {
        $this->saveAndCreateNext = true;
        $this->save();

        // رفرش کردن صفحه
        $this->redirect($this->getResource()::getUrl('create'));
    }

    public function cancel()
    {
        // هدایت کاربر به صفحه دسته‌بندی‌ها
        $this->redirect($this->getResource()::getUrl('index'));
    }
}
