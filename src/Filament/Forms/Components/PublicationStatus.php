<?php

namespace Novius\LaravelFilamentPublishable\Filament\Forms\Components;

use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\Model;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Enums\PublicationStatus as PublicationStatusEnum;
use Novius\LaravelPublishable\Traits\Publishable;

class PublicationStatus extends ToggleButtons
{
    use IsPublishable;

    protected function setUp(): void
    {
        parent::setUp();

        $statuses = [
            PublicationStatusEnum::draft->value => PublicationStatusEnum::draft->getLabel(),
            PublicationStatusEnum::published->value => PublicationStatusEnum::published->getLabel(),
            PublicationStatusEnum::unpublished->value => PublicationStatusEnum::unpublished->getLabel(),
            PublicationStatusEnum::scheduled->value => PublicationStatusEnum::scheduled->getLabel(),
        ];

        $this->label(trans('laravel-filament-publishable::messages.fields.publication_status'));
        $this->required();
        $this->default(PublicationStatusEnum::draft->value);
        $this->inline();
        $this->options(function (?Model $record) use ($statuses) {
            /** @phpstan-ignore-next-line  */
            /** @var Model&Publishable|null $model */
            $model = $this->publishableModel();

            if ($record && $model) {
                if ($record->{$model->getPublishedFirstAtColumn()} !== null) {
                    unset($statuses[PublicationStatusEnum::draft->value]);
                } else {
                    unset($statuses[PublicationStatusEnum::unpublished->value]);
                }
            }

            return $statuses;
        });
        $this->icons($this->publicationIcons());
        $this->colors($this->publicationColors());
        $this->live();
    }
}
