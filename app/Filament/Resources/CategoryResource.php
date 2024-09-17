<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
//use App\Filament\Resources\CategoryResource\RelationManagers;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Modules\CMM\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class CategoryResource extends Resource
{



    protected static ?string $resourcename = 'Category';
    protected static ?string $translatename = 'دسته ها';
    protected static ?string $translatenamesingename = 'دسته ';
    protected static ?string $model = Category::class;



    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Collections';

    protected static ?string $label = 'دسته '; // Initialized directly
    protected static ?string $pluralLabel = 'دسته ها'; // Initialized directly




    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('نام')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns())
            ->actions(self::getTableActions())
            ->bulkActions(self::getBulkActions())
            ->searchable()
            ->defaultSort('name', 'asc'); // Default sorting
    }

    private static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('نام دسته')
                ->sortable(),
        ];
    }

    private static function getTableActions(): array
    {
        return [
            Tables\Actions\DeleteAction::make('delete')
                ->label('حذف')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->action(function ($record) {
                    $record->delete();
                    Notification::make()
                        ->title('دسته با موفقیت حذف شد!')
                        ->success()
                        ->send();
                }),
            self::openModalAction('ویرایش', 'heroicon-o-pencil-square', 'جزئیات دسته', 'جزئیات دسته را ویرایش کنید.', 'success')
                ->action(function ($record, array $data) {
                    // Ensure order_column is an integer
                    if (isset($data['order_column']) && is_array($data['order_column'])) {
                        $data['order_column'] = (int) reset($data['order_column']);
                    }
                    $record->update($data);
                    Notification::make()
                        ->title('دسته با موفقیت ویرایش شد!')
                        ->success()
                        ->send();
                }),
        ];
    }

    private static function openModalAction(string $label, string $icon, string $heading, string $subheading, string $color = 'default'): Action
    {
        return Action::make('openModal')
            ->label($label)
            ->icon($icon)
            ->modalHeading($heading)
            ->modalSubheading($subheading)
            ->modalButton('بستن')
            ->color($color)
            ->form(self::getCategoryDetailsForm());
    }

    private static function getCategoryDetailsForm($record = null): array
    {
        return [
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
                ->options(Category::all()->pluck('name', 'id'))
                ->default(fn($record) => $record->parent_id),

            Forms\Components\TextInput::make('slug')
                ->label('نامک')
                ->default(fn($record) => $record->slug),

            Forms\Components\Select::make('order_column') // تغییر از CheckboxList به Select
                ->label('ترتیب')
                ->options(array_combine(range(1, 20), range(1, 20)))
                ->columns(2) // دو ستون افقی
                ->default(fn($record) => $record->order_column),

                CuratorPicker::make('image')
                ->required(),
        ];
    }

    private static function getBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'), // Corrected class reference
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
