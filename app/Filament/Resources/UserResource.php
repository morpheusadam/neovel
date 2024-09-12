<?php
namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('username')->label('نام کاربری')->required(),
                TextInput::make('phone')->label('تلفن')->required(),
                TextInput::make('name')->label('نام')->required(),
                TextInput::make('email')->label('ایمیل')->email()->required(),
                TextInput::make('password')->label('رمز عبور')->password()->required()->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                Select::make('roles')->label('نقش‌ها')->multiple()->relationship('roles', 'role_name'),
                Checkbox::make('is_active')->label('فعال'), // Changed from TextInput to Checkbox
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('شناسه'),
                TextColumn::make('username')->label('نام کاربری'),
                TextColumn::make('phone')->label('تلفن'),
                TextColumn::make('name')->label('نام'),
                TextColumn::make('email')->label('ایمیل'),
                TextColumn::make('is_active')->label('فعال')
                    ->badge()
                    ->colors([
                        'success' => fn ($state): bool => $state,
                        'danger' => fn ($state): bool => !$state,
                    ]),
                TextColumn::make('created_at')->label('تاریخ ایجاد')->dateTime(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
