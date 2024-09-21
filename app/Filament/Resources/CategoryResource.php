<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Modules\Mag\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    /**
     * Get the navigation label.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('categories');
    }

    /**
     * Get the breadcrumb.
     *
     * @return string
     */
    public static function getBreadcrumb(): string
    {
        return __('categories');
    }

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 2;

    /**
     * Get the navigation group.
     *
     * @return ?string
     */
    public static function getNavigationGroup(): ?string
    {
        return __('blog');
    }

    /**
     * Get the navigation badge.
     *
     * @return ?string
     */
    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }

    /**
     * Define the form schema.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label(__('name'))
                ->required()
                ->maxLength(255),
        ]);
    }

    /**
     * Get the plural label.
     *
     * @return string
     */
    public static function getPluralLabel(): string
    {
        return __('manage_category');
    }

    /**
     * Define the table schema.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('image_id')
                    ->label(__('image'))
                    ->circular()
                    ->size(32),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('category_name'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_column')
                    ->label(__('order'))
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_visible')
                    ->label(__('visible'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('parent_category'))
                    ->default(__('no_parent_category')),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make('delete')
                    ->label(__('delete'))
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->action(function ($record) {
                        $record->delete();
                        Notification::make()
                            ->title(__('category_deleted_successfully'))
                            ->success()
                            ->send();
                    }),
                Action::make('openModal')
                    ->label(__('edit'))
                    ->icon('heroicon-o-pencil-square')
                    ->modalHeading(__('details'))
                    ->modalSubheading(__('edit_category_details'))
                    ->modalButton(__('close'))
                    ->color('success')
                    ->form(static::getEditFormSchema())
                    ->action(function ($record, array $data) {
                        if (isset($data['order_column']) && is_array($data['order_column'])) {
                            $data['order_column'] = (int) reset($data['order_column']);
                        }
                        $record->update($data);
                        Notification::make()
                            ->title(__('category_updated_successfully'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions(static::getBulkActions())
            ->searchable()
            ->defaultSort('name', 'asc');
    }

    /**
     * Get the form schema for editing a category.
     *
     * @return array
     */
    protected static function getEditFormSchema(): array
    {
        return [
            Forms\Components\Toggle::make('is_visible')
                ->label(__('visible'))
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
                ->label(__('image'))
                ->required(),
        ];
    }

    /**
     * Get the bulk actions.
     *
     * @return array
     */
    protected static function getBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * Get the pages for the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
