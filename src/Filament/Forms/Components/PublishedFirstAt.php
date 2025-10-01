<?php

namespace Novius\LaravelFilamentPublishable\Filament\Forms\Components;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Traits\Publishable;

class PublishedFirstAt extends DateTimePicker
{
    use IsPublishable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('laravel-filament-publishable::messages.fields.published_first_at'));
        $this->hidden(function (Get $get, Component $component, ?Model $record) {
            if (! $record) {
                return true;
            }

            /** @var Model&Publishable $record */
            $model = $this->publishableModel($record);

            return $model && ! $record->isPublished();
        });
        $this->rule('required');
        $this->required();
    }
}
