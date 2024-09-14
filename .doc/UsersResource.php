<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UsersResource extends Resource
{


    /**
     * Get the title of the resource.
     *
     * @return string
     */


    protected static ?string $navigationIcon = 'heroicon-o-user'; // تغییر آیکون به یک آیکون مناسب‌تر
    protected static ?string $navigationGroup = 'کاربران'; // افزودن گروه

    protected static ?string $label = 'کاربران'; // نام تک
    protected static ?string $pluralLabel = 'کاربران'; // نام جمع
    protected static ?string $model = User::class;

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
                // Define form fields here
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
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete User')
                    ->modalHeading('Are you sure?')
                    ->modalSubheading('This action is irreversible and the user will be permanently deleted.'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('createPermission')
                    ->label('Manage Permissions')
                    ->icon('heroicon-o-shield-check') // Change icon to a suitable one
                    ->color('danger') // Set icon color to red
                    ->action(function (array $data) {
                        $role = Role::find($data['role_id']);
                        $role->permissions()->sync($data['permission_ids']);
                    })
                    ->form([
                        Forms\Components\Select::make('role_id')
                            ->label('Role')
                            ->options(Role::all()->pluck('role_name', 'id'))
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $role = Role::find($state);
                                $set('permission_ids', $role ? $role->permissions->pluck('id')->toArray() : []);
                            }),
                        Forms\Components\CheckboxList::make('permission_ids')
                            ->label('Permissions')
                            ->options(Permission::all()->pluck('permission_name', 'id'))
                            ->required(),
                    ]),
            ]);
    }

    /**
     * Define the relations for the resource.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // Define relations here
        ];
    }

    /**
     * Define the pages for the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
        ];
    }

    /**
     * Handle the action for a new button.
     *
     * @return void
     */
    public static function handleNewButtonAction()
    {
        // Code for the new button action
    }
}
