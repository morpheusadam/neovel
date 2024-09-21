<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\Role;
use Rawilk\FilamentPasswordInput\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    /**
     * Get the plural label for the resource.
     *
     * @return string
     */
    public static function getPluralLabel(): string
    {
        return __('manage_users');
    }

    /**
     * Get the navigation icon for the resource.
     *
     * @return string
     */
    protected static ?string $navigationIcon = 'heroicon-o-users';

    /**
     * Get the navigation group for the resource.
     *
     * @return ?string
     */
    public static function getNavigationGroup(): ?string
    {
        return __('users');
    }

    /**
     * Get the navigation label for the resource.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('users');
    }

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
     * Get the breadcrumb for the resource.
     *
     * @return string
     */
    public static function getBreadcrumb(): string
    {
        return __('users');
    }

    /**
     * Define the form schema for the resource.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('name'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label(__('email'))
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Select::make('role_ids')
                    ->label(__('role'))
                    ->relationship('roles', 'role_name')
                    ->options(Role::all()->pluck('role_name', 'id')->toArray())
                    ->required(),

                Password::make('password')
                    ->label(__('password'))
                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->revealable()
                    ->maxLength(255),
            ]);
    }

    /**
     * Define the table schema for the resource.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('email'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role_names')
                    ->label(__('role'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(__('edit')),
                Tables\Actions\DeleteAction::make()->label(__('delete')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label(__('delete')),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label(__('create')),
            ]);
    }

    /**
     * Get the relation managers for the resource.
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
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
