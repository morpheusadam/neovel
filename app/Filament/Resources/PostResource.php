<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Modules\Mag\Models\Post;

class PostResource extends Resource
{
    /**
     * The resource record title.
     */
    public static function getBreadcrumb(): string
    {
        return __('post');
    }

    /**
     * Get the plural label for the resource.
     *
     * @return string
     */
    public static function getPluralLabel(): string
    {
        return __('manage_posts');
    }

    /**
     * Get the navigation label for the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('post');
    }

    /**
     * The resource model.
     */
    protected static ?string $model = Post::class;

    /**
     * Get the navigation group for the resource.
     *
     * @return ?string
     */
    public static function getNavigationGroup(): ?string
    {
        return __('blog');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return __('post');
    }

    /**
     * Get the header for the resource.
     *
     * @return string
     */
    public function getHeader(): string
    {
        return __('post');
    }

    /**
     * The resource icon.
     */
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    /**
     * The resource navigation sort order.
     */
    protected static ?int $navigationSort = 1;

    /**
     * Get the navigation badge for the resource.
     *
     * @return ?string
     */
    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }

    /**
     * Get the form for the resource.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\Section::make()
                            ->columnSpan(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label(__('title'))
                                    ->placeholder(__('title_placeholder'))
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, string $operation, ?string $old, ?string $state) {
                                        if (($get('slug') ?? '') !== Str::slug($old) || $operation !== 'create') {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    })
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus(),

                                Forms\Components\Builder::make('content')
                                    ->label(__('content'))
                                    ->required()
                                    ->columnSpanFull()
                                    ->default([
                                        ['type' => 'markdown'],
                                    ])
                                    ->blocks([
                                        Builder\Block::make('markdown')
                                            ->label(__('markdown'))
                                            ->schema([
                                                Forms\Components\MarkdownEditor::make('content')
                                                    ->required(),
                                            ]),

                                        Builder\Block::make('figure')
                                            ->schema([
                                                CuratorPicker::make('image')
                                                    ->required(),

                                                Forms\Components\Fieldset::make()
                                                    ->label(__('details'))
                                                    ->schema([
                                                        Forms\Components\TextInput::make('alt')
                                                            ->label(__('alt_text'))
                                                            ->placeholder(__('enter_alt_text'))
                                                            ->required()
                                                            ->maxLength(255),

                                                        Forms\Components\TextInput::make('caption')
                                                            ->placeholder(__('enter_caption'))
                                                            ->maxLength(255),
                                                    ]),
                                            ]),
                                    ]),
                            ]),

                        Forms\Components\Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->placeholder(__('enter_slug'))
                                    ->alphaDash()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\Select::make('category_id')
                                    ->label(__('category'))
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable(),

                                Forms\Components\Select::make('user_id')
                                    ->label(__('author'))
                                    ->relationship('user', 'name')
                                    ->default(fn() => auth()->id())
                                    ->searchable()
                                    ->required(),

                                CuratorPicker::make('image_id')
                                    ->label(__('featured_image')),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__('publish_date'))
                                    ->default(now())
                                    ->required(),

                                Forms\Components\Toggle::make('is_published')
                                    ->label(__('published'))
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    /**
     * Get the table for the resource.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('image')
                    ->label(__('image'))
                    ->circular()
                    ->size(32),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('title'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('author'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label(__('published'))
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Get the relationships for the resource.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            //
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
