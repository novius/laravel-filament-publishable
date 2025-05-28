<?php

namespace Novius\LaravelFilamentPublishable\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Enums\PublicationStatus as PublicationStatusEnum;

class PublicationStatus extends Select
{
    use IsPublishable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('laravel-filament-publishable::messages.fields.publication_status'));
        $this->rules('required');
        $this->options(function (?Model $record) {
            $statuses = [
                PublicationStatusEnum::draft->value => PublicationStatusEnum::draft->getLabel(),
                PublicationStatusEnum::published->value => PublicationStatusEnum::published->getLabel(),
                PublicationStatusEnum::unpublished->value => PublicationStatusEnum::unpublished->getLabel(),
                PublicationStatusEnum::scheduled->value => PublicationStatusEnum::scheduled->getLabel(),
            ];

            if ($record && $this->isPublishable($record)) {
                if ($record->{$this->name} !== null) {
                    unset($statuses[PublicationStatusEnum::draft->value]);
                } else {
                    unset($statuses[PublicationStatusEnum::unpublished->value]);
                }
            }

            return $statuses;
        });
        $this->afterStateUpdated(function (?string $state, ?string $old, Model $record) {
            $record->{$this->name} = PublicationStatusEnum::tryFrom($state);
        });
        $this->default(PublicationStatusEnum::draft->value);
        $this->live();
    }
}
