<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Morilog\Jalali\Jalalian;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'مدیریت کاربران'; // افزودن گروه

    protected static ?string $label = 'مدیریت کاربران'; // نام تک
    protected static ?string $pluralLabel = 'مدیریت کاربران'; // نام جمع




    public static function form(Form $form): Form
    {
        return $form->schema([
            // Define form schema here if needed
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns())
            ->headerActions(self::getHeaderActions())
            ->actions(self::getTableActions())
            ->bulkActions(self::getBulkActions())
            ->searchable(); // Enable search functionality
    }

    private static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(), // Make column searchable
            Tables\Columns\TextColumn::make('email')
                ->sortable()
                ->searchable(), // Make column searchable
            Tables\Columns\TextColumn::make('phone')
                ->sortable()
                ->searchable(), // Make column searchable
            Tables\Columns\TextColumn::make('roles.role_name')
                ->label('Role')
                ->sortable()
                ->searchable(), // Make column searchable
        ];
    }

    private static function getHeaderActions(): array
    {
        return [
            self::createPermissionAction(),
            self::viewRolesAction(),
        ];
    }

    private static function createPermissionAction(): Action
    {
        return Action::make('ManagePermission')
            ->label('Manage  Permission')
            ->icon('heroicon-o-user-group')
            ->color('success')
            ->action(function (array $data, $action) {
                self::handleCreatePermission($data, $action);
            })
            ->modalHeading('Manage  Permission ')
            ->modalSubheading('Assign permissions to a role.')
            ->modalSubmitActionLabel('Yes, save')
            ->modalAlignment(Alignment::Center)
            ->stickyModalHeader()
            ->closeModalByClickingAway(false)
            ->form(self::getCreatePermissionForm());
    }

    public static function handleCreatePermission(array $data, $action)
    {
        $role = Role::find($data['role_id']);
        $role->permissions()->sync($data['permission_ids']);
        session()->flash('success', 'Permissions updated successfully!');
        Notification::make()
            ->title('Permissions updated successfully!')
            ->success()
            ->send();
        $action->halt();
    }

    private static function getCreatePermissionForm(): array
    {
        return [
            Select::make('role_id')
                ->label('Role')
                ->options(Role::all()->pluck('role_name', 'id'))
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    $role = Role::find($state);
                    $set('permission_ids', $role ? $role->permissions->pluck('id')->toArray() : []);
                }),
            CheckboxList::make('permission_ids')
                ->label('Permissions')
                ->options(Permission::all()->pluck('permission_name', 'id'))
                ->required(),
        ];
    }


    private static function viewRolesAction(): Action
    {
        return Action::make('CreateRoles')
            ->label('Create Roles')
            ->icon('heroicon-o-eye')
            ->color('success')
            ->action(function (array $data) {
                $role = Role::create([
                    'role_name' => $data['role_name'],
                ]);
                $role->permissions()->sync($data['permission_ids']);
                Notification::make()
                    ->title('Role created successfully!')
                    ->success()
                    ->send();
            })
            ->form([
                Forms\Components\TextInput::make('role_name')
                    ->label('نام نقش')
                    ->required(),
                Forms\Components\CheckboxList::make('permission_ids')
                    ->label('انتخاب دسترسی')
                    ->options(Permission::all()->pluck('permission_name', 'id'))
                    ->required(),
            ]);
    }

    private static function getTableActions(): array
    {
        return [
            Tables\Actions\DeleteAction::make('حذف')
                ->label('حذف')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->action(function ($record) {
                    $record->delete();
                    Notification::make()
                        ->title('User deleted successfully!')
                        ->success()
                        ->send();
                }),
                self::openModalAction('ویرایش', 'heroicon-o-pencil-square', 'User Details', 'Here are the details of the user.', 'success'),

        ];
    }

    private static function openModalAction(string $label, string $icon, string $heading, string $subheading, string $color = 'default'): Action
    {
        return Action::make('openModal')
            ->label($label)
            ->icon($icon)
            ->modalHeading($heading)
            ->modalSubheading($subheading)
            ->modalButton('Close')
            ->color($color)
            ->form(self::getUserDetailsForm());
    }

    private static function getUserDetailsForm($record = null): array
    {
        return [
            Forms\Components\FileUpload::make('avatar')
                ->label('Avatar')
                ->image() // This ensures the file is an image
                ->directory('avatars')
                ->maxSize(1024) // Maximum file size in kilobytes
                ->columnSpan('full'), // Set the width to full

            Forms\Components\Textarea::make('bio')
                ->label('بیوگرافی')
                ->maxLength(5000)
                ->columnSpan('full'), // Set the width to full

            Forms\Components\TextInput::make('name')
                ->label('نام')
                ->maxLength(255)
                ->default(fn($record) => $record->name),

            Forms\Components\TextInput::make('email')
                ->label('ایمیل')
                ->email()
                ->maxLength(255)
                ->default(fn($record) => $record->email),

            Forms\Components\TextInput::make('new_password')
                ->label('رمز جدید')
                ->password()
                ->minLength(8),

            Forms\Components\TextInput::make('phone')
                ->label('تلفن همراه')
                ->tel()
                ->maxLength(15)
                ->default(fn($record) => $record->phone),

            Forms\Components\TextInput::make('last_name')
                ->label('نام خانوادگی')
                ->maxLength(255)
                ->default(fn($record) => $record->last_name),

            Forms\Components\TextInput::make('address')
                ->label('آدرس')
                ->maxLength(255)
                ->default(fn($record) => $record->address),

            Forms\Components\DatePicker::make('birth_date')
                ->label('تاریخ تولد')
                ->jalali()
                ->default(fn($record) => $record->birth_date),

            Forms\Components\Select::make('gender')
                ->label('جنسیت')
                ->options([
                    'male' => 'مرد',
                    'female' => 'زن',
                ])
                ->default(fn($record) => $record->gender),

            Forms\Components\TextInput::make('website')
                ->label('وب‌سایت')
                ->maxLength(255)
                ->default(fn($record) => $record->website),

            Forms\Components\Select::make('role')
                ->label('نقش')
                ->options(Role::all()->pluck('role_name', 'id'))
                ->default(fn($record) => UserRole::where('user_id', $record->id)->value('role_id'))
                ->required(),

            Forms\Components\Checkbox::make('is_active')
                ->label('فعال')
                ->default(fn($record) => $record->is_active),

            // New fields added
            Forms\Components\TextInput::make('created_at')
                ->label('تاریخ ایجاد')
                ->disabled()
                ->default(fn($record) => $record->created_at),

            Forms\Components\TextInput::make('updated_at')
                ->label('تاریخ بروزرسانی')
                ->disabled()
                ->default(fn($record) => $record->updated_at),
        ];
    }
    private static function getBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])
        ];
    }

    public static function getRelations(): array
    {
        return [
            // Define relations here if needed
        ];
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
