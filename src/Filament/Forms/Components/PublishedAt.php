<?php

namespace Novius\LaravelFilamentPublishable\Filament\Forms\Components;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\DateTimePicker;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Enums\PublicationStatus;

class PublishedAt extends DateTimePicker
{
    use IsPublishable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('laravel-filament-publishable::messages.fields.published_at'));
        $this->hidden(function (Get $get) {
            $model = $this->publishableModel();

            return $model && $get($model->getPublicationStatusColumn()) !== PublicationStatus::scheduled->value;
        });
        $this->rule('required');
        $this->required();
    }
}
