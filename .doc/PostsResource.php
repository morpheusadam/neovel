<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostsResource\Pages;
use Modules\CMS\Models\Post;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action; // اضافه کردن این خط

class PostsResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'مدیریت محتوا';

    protected static ?string $label = 'مدیریت محتوا';
    protected static ?string $pluralLabel = 'مدیریت محتوا';

    public static function form(Form $form): Form
    {
        return $form;

    }

     public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('عنوان'),
                Tables\Columns\TextColumn::make('user.name')->label('نویسنده'),
                Tables\Columns\TextColumn::make('created_at')->label('تاریخ ایجاد')->date(),
                Tables\Columns\TextColumn::make('comments_count')
                    ->label('تعداد کامنت‌ها')
                    ->counts('comments')
                    ->badge()
                    ->color('danger'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('ویرایش'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->headerActions([
                Action::make('createCategory')
                    ->label('ایجاد دسته‌بندی')
                    ->url(env('APP_URL') . '/admin/categories/create') // تغییر این خط
                    ->icon('heroicon-o-plus'),
                Action::make('viewCategories') // اضافه کردن این خط
                    ->label('نمایش دسته‌بندی‌ها') // اضافه کردن این خط
                    ->url(env('APP_URL') . '/admin/categories') // اضافه کردن این خط
                    ->icon('heroicon-o-eye'), // اضافه کردن این خط
            ])
            ->defaultSort('created_at', 'desc');
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
