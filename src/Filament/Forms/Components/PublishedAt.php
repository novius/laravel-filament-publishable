<?php

namespace Novius\LaravelFilamentPublishable\Filament\Forms\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Get;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Enums\PublicationStatus;

class PublishedAt extends DateTimePicker
{
    use IsPublishable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('laravel-filament-publishable::messages.fields.published_at'));
        $this->hidden(function (Get $get, Component $component) {
            $modelClass = $component->getModel();

            return $this->isPublishable($modelClass) && $get($this->publishableModel($modelClass)->getPublicationStatusColumn()) !== PublicationStatus::scheduled->value;
        });
        $this->rule('required');
        $this->required();
    }
}
