<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Concerns\HasPreview;
use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditPost extends EditRecord
{
    use HasPreview, HasPreviewModal;

    /**
     * The resource model.
     */
    protected static string $resource = PostResource::class;

    /**
     * Get the URL for the preview modal.
     *
     * @return ?string
     */
    protected function getPreviewModalUrl(): ?string
    {
        $this->generatePreviewSession();

        return route('post.show', [
            'post' => $this->record->slug,
            'previewToken' => $this->previewToken,
        ]);
    }

    /**
     * Define the header actions available on the page.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(),
            $this->viewPostAction(),
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Create the view post action.
     *
     * @return Actions\Action
     */
    private function viewPostAction(): Actions\Action
    {
        return Actions\Action::make('view')
            ->label(__('view_post'))
            ->url(fn($record) => $record->url)
            ->extraAttributes(['target' => '_blank']);
    }
}
