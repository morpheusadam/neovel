<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use App\Models\UserRole;

use App\Models\Role;
use App\Models\UserMeta;

use Filament\Actions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;


class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image() // This ensures the file is an image
                    ->directory('avatars')
                    ->maxSize(1024) // Maximum file size in kilobytes
                    ->columnSpan('full'), // Set the width to full

                Textarea::make('bio')
                    ->label('بیوگرافی')
                    ->maxLength(5000)
                    ->columnSpan('full'), // Set the width to full
                TextInput::make('name')
                    ->label('نام')
                    ->maxLength(255)
                    ->default(fn($record) => $record->name),

                TextInput::make('email')
                    ->label('ایمیل')
                    ->email()
                    ->maxLength(255)
                    ->default(fn($record) => $record->email),

                TextInput::make('new password')
                    ->label('رمز جدید')
                    ->password()
                    ->minLength(8),

                TextInput::make('phone')
                    ->label('تلفن همراه')
                    ->tel()
                    ->maxLength(15)
                    ->default(fn($record) => $record->phone),

                TextInput::make('last_name')
                    ->label('نام خانوادگی')
                    ->maxLength(255),

                TextInput::make('address')
                    ->label('آدرس')
                    ->maxLength(255),

                DatePicker::make('birth_date')
                    ->label('تاریخ تولد')
                    ->jalali(),

                Select::make('gender')
                    ->label('جنسیت')
                    ->options([
                        'male' => 'مرد',
                        'female' => 'زن',
                    ]),

                TextInput::make('website')
                    ->label('وب‌سایت')
                    ->maxLength(255),


                Select::make('role')
                    ->label('نقش')
                    ->options(Role::all()->pluck('role_name', 'id'))
                    ->default(fn($record) => UserRole::where('user_id', $record->id)->value('role_id'))
                    ->required(),
                    Checkbox::make('is_active')
                    ->default(fn($record) => $record->is_active),

            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $userId = $this->record->id;
        //    dd(vars: $userId);

        //  dd($data['role']);

        // Save role data
        if (isset($data['role'])) {
            // Delete existing role for the user
            UserRole::where('user_id', $this->record->id)->delete();

            // Create new role for the user
            UserRole::create([
                'user_id' => $this->record->id,
                'role_id' => $data['role']
            ]);
        }

        // Save meta data
        $metaFields = ['last_name', 'avatar', 'address', 'birth_date', 'gender', 'website', 'bio'];
        foreach ($metaFields as $field) {
            if (isset($data[$field])) {
                UserMeta::updateOrCreate(
                    ['user_id' => $userId, 'meta_key' => $field],
                    ['meta_value' => $data[$field]]
                );
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $userId = $this->record->id;

        // Load role data
        $data['role'] = UserRole::where('user_id', $userId)->value('role_id');

        // Load meta data
        $metaFields = ['last_name', 'avatar', 'address', 'birth_date', 'gender', 'website', 'bio'];
        foreach ($metaFields as $field) {
            $meta = UserMeta::where('user_id', $userId)->where('meta_key', $field)->first();
            if ($meta) {
                $data[$field] = $meta->meta_value;
            }
        }

        return $data;
    }
}
