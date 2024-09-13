<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUsers extends CreateRecord
{
    /**
     * Get the title of the page.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return 'Create New User'; // Change the page title
    }

    /**
     * The resource associated with the page.
     *
     * @var string
     */
    protected static string $resource = UsersResource::class;
}
