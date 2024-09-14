<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Models\Role;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\UserRole;
use Morilog\Jalali\Jalalian;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;
    protected static string $createButtonLabel = 'ایجاد کاربر جدید';
    protected static string $createButtonColor = 'success';



    protected function getModalHeading(): string
    {
        return 'ایجاد کاربر جدید'; // عنوان modal
    }
    

    public function mount(): void
    {
        parent::mount();
        // محتوای تست
        Notification::make()
            ->title('این یک پیام تست است.')
            ->success()
            ->send();
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image() // This ensures the file is an image
                    ->directory('avatars')
                    ->maxSize(1024), // Maximum file size in kilobytes
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
            ]);
    }

    protected function handleRecordCreation(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'] ?? null,
        ]);

        // Save meta data
        $metaFields = ['last_name', 'avatar', 'address', 'birth_date', 'gender', 'website', 'bio'];
        foreach ($metaFields as $field) {
            if (isset($data[$field])) {
                UserMeta::updateOrCreate(
                    ['user_id' => $user->id, 'meta_key' => $field],
                    ['meta_value' => $data[$field]]
                );
            }
        }

        // Save role data
        if (isset($data['role_id'])) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $data['role_id']
            ]);
        }

        return $user;
    }
}
