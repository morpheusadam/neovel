<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Modules\User\Models\Role;
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\Permission;

class ListUsers extends ListRecords
{
    /**
     * The resource model.
     */
    protected static string $resource = UserResource::class;

    /**
     * Define the header actions available on the page.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            $this->createUserAction(),
            $this->createRoleAction(),
            $this->manageRoleAction(),
        ];
    }

    /**
     * Create a new user action.
     *
     * @return Actions\CreateAction
     */
    private function createUserAction(): Actions\CreateAction
    {
        return Actions\CreateAction::make('userCreator')
            ->label(__('create_user'))
            ->form($this->getUserFormSchema())
            ->modalHeading(__('create_user'))
            ->modalSubheading(__('create_user_manage'))
            ->modalSubmitActionLabel(__('save'))
            ->modalAlignment(Alignment::Center)
            ->stickyModalHeader()
            ->closeModalByClickingAway(false);
    }

    /**
     * Get the form schema for creating a user.
     *
     * @return array
     */
    private function getUserFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(2)
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

                    Password::make('password')
                        ->label(__('password'))
                        ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                        ->dehydrated(fn(?string $state): bool => filled($state))
                        ->required(fn(string $operation): bool => $operation === 'create')
                        ->revealable()
                        ->maxLength(255),

                    Password::make('password_confirmation')
                        ->label(__('confirm_password'))
                        ->same('password')
                        ->required(fn(string $operation): bool => $operation === 'create')
                        ->revealable()
                        ->maxLength(255),

                    Select::make('role_ids')
                        ->label(__('role'))
                        ->relationship('roles', 'role_name')
                        ->options(Role::all()->pluck('role_name', 'id')->toArray())
                        ->required(),
                ]),
        ];
    }

    /**
     * Manage role permissions action.
     *
     * @return Action
     */
    private function manageRoleAction(): Action
    {
        return Action::make('ManagePermission')
            ->label(__('manage_permission'))
            ->icon('heroicon-o-user-group')
            ->color('success')
            ->action(fn(array $data, $action) => $this->handleManageRole($data, $action))
            ->modalHeading(__('manage_permission'))
            ->modalSubheading(__('assign_permissions_to_a_role'))
            ->modalSubmitActionLabel(__('yes_save'))
            ->modalAlignment(Alignment::Center)
            ->stickyModalHeader()
            ->closeModalByClickingAway(false)
            ->form($this->getManageRoleFormSchema());
    }

    /**
     * Handle the manage role action.
     *
     * @param array $data
     * @param Action $action
     * @return void
     */
    private function handleManageRole(array $data, Action $action): void
    {
        $role = Role::find($data['role_id']);
        $role->permissions()->sync($data['permission_ids']);
        session()->flash('success', __('permissions_updated_successfully'));
        Notification::make()
            ->title(__('permissions_updated_successfully'))
            ->success()
            ->send();
        $action->halt();
    }

    /**
     * Get the form schema for managing role permissions.
     *
     * @return array
     */
    private function getManageRoleFormSchema(): array
    {
        return [
            Select::make('role_id')
                ->label(__('role'))
                ->options(Role::all()->pluck('role_name', 'id'))
                ->required()
                ->reactive()
                ->afterStateUpdated(fn(callable $set, $state) => $this->updatePermissions($set, $state)),
            Forms\Components\MultiSelect::make('permission_ids')
                ->label(__('permissions'))
                ->options(Permission::all()->pluck('permission_name', 'id'))
                ->required(),
        ];
    }

    /**
     * Update the permissions based on the selected role.
     *
     * @param callable $set
     * @param mixed $state
     * @return void
     */
    private function updatePermissions(callable $set, $state): void
    {
        $role = Role::find($state);
        $set('permission_ids', $role ? $role->permissions->pluck('id')->toArray() : []);
    }

    /**
     * Create a new role action.
     *
     * @return Actions\CreateAction
     */
    private function createRoleAction(): Actions\CreateAction
    {
        return Actions\CreateAction::make('roleCreator')
            ->label(__('create_roles'))
            ->icon('heroicon-o-eye')
            ->color('success')
            ->action(fn(array $data) => $this->handleCreateRole($data))
            ->modalHeading(__('create_role'))
            ->modalSubheading(__('create_role_subheading'))
            ->modalSubmitActionLabel(__('save'))
            ->modalAlignment(Alignment::Center)
            ->stickyModalHeader()
            ->closeModalByClickingAway(false)
            ->form($this->getCreateRoleFormSchema());
    }

    /**
     * Handle the create role action.
     *
     * @param array $data
     * @return void
     */
    private function handleCreateRole(array $data): void
    {
        try {
            $role = Role::create([
                'role_name' => $data['role_name'],
            ]);
            $role->permissions()->sync($data['permission_ids']);
            Notification::make()
                ->title(__('created_successfully'))
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Get the form schema for creating a role.
     *
     * @return array
     */
    private function getCreateRoleFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('role_name')
                ->label(__('role_name'))
                ->required(),
            Forms\Components\MultiSelect::make('permission_ids')
                ->label(__('choose_access'))
                ->options(Permission::all()->pluck('permission_name', 'id'))
                ->required(),
        ];
    }
}
