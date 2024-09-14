<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Morilog\Jalali\Jalalian;
use App\Models\Role;
use App\Models\UserMeta;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Rawilk\FilamentPasswordInput\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->action('deleteUser'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('avatar')
                ->label('Avatar')
                ->image()
                ->directory('avatars')
                ->maxSize(1024),

            Textarea::make('bio')
                ->label('Biography')
                ->maxLength(5000),

            TextInput::make('name')
                ->label('Name')
                ->required(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

            Password::make('password')
                ->label('Password')
                ->copyable(color: 'warning')
                ->regeneratePassword(color: 'primary')
                ->inlineSuffix()
                ->default(fn($record) => $record->password_plain),

            TextInput::make('phone')
                ->label('Phone')
                ->tel()
                ->maxLength(15),

            TextInput::make('last_name')
                ->label('Last Name')
                ->maxLength(255),

            TextInput::make('address')
                ->label('Address')
                ->maxLength(255),

            DatePicker::make('birth_date')
                ->label('Birth Date')
                ->jalali()
                ->minDate(Jalalian::fromFormat('Y-m-d', '1365-01-01')->toCarbon())
                ->maxDate(Jalalian::now()->toCarbon()),

            TextInput::make('website')
                ->label('Website')
                ->maxLength(255),

            Select::make('gender')
                ->label('Gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                ]),

            Select::make('role_id')
                ->label('Role')
                ->options(Role::all()->pluck('role_name', 'id'))
                ->required(),

            Checkbox::make('is_active')
                ->label('Active'),
        ]);
    }

    protected function fillForm(): void
    {
        $user = $this->record;
        $meta = UserMeta::where('user_id', $user->id)->pluck('meta_value', 'meta_key')->toArray();
        $role = UserRole::where('user_id', $user->id)->first();

        $this->form->fill([
            'avatar' => $meta['avatar'] ?? null,
            'bio' => $meta['bio'] ?? null,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'last_name' => $meta['last_name'] ?? null,
            'address' => $meta['address'] ?? null,
            'birth_date' => $meta['birth_date'] ?? null,
            'website' => $meta['website'] ?? null,
            'gender' => $meta['gender'] ?? null,
            'role_id' => $role->role_id ?? null,
            'is_active' => $user->is_active,
            'password' => $user->password_plain, // نمایش مقدار قابل خواندن پسورد

        ]);
    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        $data = $this->form->getState();
        $user = $this->record;

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'is_active' => $data['is_active'],
            //   'password' => $data['password'], // ذخیره مقدار اصلی پسورد
        ]);

        $this->saveUserMeta($user->id, $data);
        $this->saveUserRole($user->id, $data['role_id']);

        parent::save($shouldRedirect, $shouldSendSavedNotification);
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
        UserRole::updateOrCreate(
            ['user_id' => $userId],
            ['role_id' => $roleId]
        );
    }

    public function deleteUser(): void
    {
        $user = $this->record;

        UserMeta::where('user_id', $user->id)->delete();
        UserRole::where('user_id', $user->id)->delete();
        $user->delete();
    }
}
