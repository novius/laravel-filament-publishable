<?php

namespace Novius\LaravelFilamentPublishable\Filament\Tables\Actions;

use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Enums\PublicationStatus;
use Novius\LaravelPublishable\Traits\Publishable;

class PublicationBulkAction extends BulkAction
{
    use IsPublishable;

    public static function getDefaultName(): ?string
    {
        return 'publication';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('laravel-filament-publishable::messages.actions.publish_unpublish'));
        $this->form([
            Select::make('publication_status')
                ->label(trans('laravel-filament-publishable::messages.fields.publication_status'))
                ->options([
                    PublicationStatus::published->value => trans('laravel-filament-publishable::messages.filters.published'),
                    PublicationStatus::unpublished->value => trans('laravel-filament-publishable::messages.filters.not_published'),
                ])
                ->required(),
        ]);

        $this->modalHeading(trans('laravel-filament-publishable::messages.actions.publish_unpublish'));

        $this->successNotificationTitle(function (array $data): string {
            if ($data['publication_status'] === PublicationStatus::published->value) {
                return trans('laravel-filament-publishable::messages.actions.publish_success');
            }

            return trans('laravel-filament-publishable::messages.actions.unpublish_success');
        });

        $this->defaultColor('warning');

        $this->icon('heroicon-o-check-circle');

        $this->action(function (array $data, Collection $records): void {
            $records->each(function (Model $record) use ($data) {
                if ($this->isPublishable($record)) {
                    /** @var Model&Publishable $record */
                    $record->{$record->getPublicationStatusColumn()} = $data['publication_status'];
                }

                return $record->save();
            });

            $this->success();
        });
    }
}
