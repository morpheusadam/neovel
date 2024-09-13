<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
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
    /**
     * Get the breadcrumbs for the page.
     *
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'Dashboard', // Link to the dashboard
            url('/admin/users') => 'User Management', // Link to the user management page
        ];
    }

    /**
     * Get the title of the page.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return 'User Management'; // Change the page title
    }

    /**
     * The resource associated with the page.
     *
     * @var string
     */
    protected static string $resource = UsersResource::class;

    /**
     * Get the actions for the page.
     *
     * @return array
     */
    protected function getActions(): array
    {
        return [
            Action::make('createUser')
                ->label('Create New User')
                ->modalHeading('Create New User')
                ->modalButton('Create')
                ->form([
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

                ])
                ->action(function (array $data): void {
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
                }),
        ];
    }
}
