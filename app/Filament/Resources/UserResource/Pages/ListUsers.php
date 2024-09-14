<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Role;
use App\Models\UserRole;
use Morilog\Jalali\Jalalian;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard',
            url('/admin/users') => 'User Management',
        ];
    }

    public function getTitle(): string
    {
        return 'User Management';
    }

    protected function getActions(): array
    {
        return [
            $this->createUserAction(),
        ];
    }

    private function createUserAction(): Action
    {
        return Action::make('createUser')
            ->label('Create New User')
            ->modalHeading('Create New User')
            ->modalButton('Create')
            ->form($this->getUserForm())
            ->action(fn(array $data) => $this->handleCreateUser($data));
    }

    private function getUserForm(): array
    {
        return [
            Forms\Components\FileUpload::make('avatar')
                ->label('Avatar')
                ->image()
                ->directory('avatars')
                ->maxSize(1024),

            Forms\Components\Textarea::make('bio')
                ->label('Biography')
                ->maxLength(5000),

            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(),

            Forms\Components\TextInput::make('phone')
                ->label('Phone')
                ->tel()
                ->maxLength(15),

            Forms\Components\TextInput::make('last_name')
                ->label('Last Name')
                ->maxLength(255),

            Forms\Components\TextInput::make('address')
                ->label('Address')
                ->maxLength(255),

            Forms\Components\DatePicker::make('birth_date')
                ->label('Birth Date')
                ->jalali()
                ->minDate(Jalalian::fromFormat('Y-m-d', '1365-01-01')->toCarbon())
                ->maxDate(Jalalian::now()->toCarbon()),

            Forms\Components\TextInput::make('website')
                ->label('Website')
                ->maxLength(255),

            Forms\Components\Select::make('gender')
                ->label('Gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                ]),

            Forms\Components\Select::make('role_id')
                ->label('Role')
                ->options(Role::all()->pluck('role_name', 'id'))
                ->required(),

            Forms\Components\Checkbox::make('is_active')
                ->label('Active'),
        ];
    }

    private function handleCreateUser(array $data): void
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'] ?? null,
        ]);

        $this->saveUserMeta($user->id, $data);
        $this->saveUserRole($user->id, $data['role_id']);
    }

    private function saveUserMeta(int $userId, array $data): void
    {
        $metaFields = ['last_name', 'avatar', 'address', 'birth_date', 'gender', 'website', 'bio'];
        foreach ($metaFields as $field) {
            if (isset($data[$field])) {
                UserMeta::updateOrCreate(
                    ['user_id' => $userId, 'meta_key' => $field],
                    ['meta_value' => $data[$field]]
                );
            }
        }
    }

    private function saveUserRole(int $userId, int $roleId): void
    {
        UserRole::create([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
    }
}
