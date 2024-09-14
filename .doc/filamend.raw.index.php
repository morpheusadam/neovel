<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostsResource\Pages;
use Modules\CMS\Models\Post;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class PostsResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection'; // تغییر آیکون به یک آیکون مناسب‌تر
    protected static ?string $navigationGroup = 'مدیریت محتوا'; // افزودن گروه

    protected static ?string $label = 'مدیریت محتوا'; // نام تک
    protected static ?string $pluralLabel = 'مدیریت محتوا'; // نام جمع

    public static function form(Form $form): Form
    {
        return $form;

    }

    public static function table(Table $table): Table
    {
        return $table;

    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePosts::route('/create'),
            'edit' => Pages\EditPosts::route('/{record}/edit'),
        ];
    }
}
