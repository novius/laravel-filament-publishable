<?php

namespace Novius\LaravelFilamentPublishable\Filament\Forms\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Enums\PublicationStatus;
use Novius\LaravelPublishable\Traits\Publishable;

class ExpiredAt extends DateTimePicker
{
    use IsPublishable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('laravel-filament-publishable::messages.fields.expired_at'));
        $this->hidden(function (Get $get, Component $component) {
            $modelClass = $component->getModel();

            return $this->isPublishable($modelClass) && $get($this->publishableModel($modelClass)->getPublicationStatusColumn()) !== PublicationStatus::scheduled->value;
        });
        $this->after(function (Get $get, Component $component) {
            $modelClass = $component->getModel();

            /** @var Model&Publishable $record */
            return $this->isPublishable($modelClass) ? $get($this->publishableModel($modelClass)->getPublishedAtColumn()) : null;
        });
    }
}
