<?php

namespace Novius\LaravelFilamentPublishable\Filament\Actions;

use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Enums\PublicationStatus;

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

        $this->label(trans('laravel-filament-publishable::messages.actions.publish_unpublish'))
            ->schema([
                Select::make('publication_status')
                    ->label(trans('laravel-filament-publishable::messages.fields.publication_status'))
                    ->options([
                        PublicationStatus::published->value => trans('laravel-filament-publishable::messages.filters.published'),
                        PublicationStatus::unpublished->value => trans('laravel-filament-publishable::messages.filters.not_published'),
                    ])
                    ->required(),
            ])
            ->modalHeading(trans('laravel-filament-publishable::messages.actions.publish_unpublish'))
            ->successNotificationTitle(function (array $data): string {
                if ($data['publication_status'] === PublicationStatus::published->value) {
                    return trans('laravel-filament-publishable::messages.actions.publish_success');
                }

                return trans('laravel-filament-publishable::messages.actions.unpublish_success');
            })
            ->defaultColor('warning')
            ->icon('heroicon-o-check')
            ->action(function (array $data, Collection $records): void {
                $records->each(function (Model $record) use ($data) {
                    $model = $this->publishableModel();

                    if ($model) {
                        $record->{$model->getPublicationStatusColumn()} = $data['publication_status'];
                    }

                    return $record->save();
                });

                $this->success();
            });
    }
}
