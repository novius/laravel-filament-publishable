<?php

namespace Novius\LaravelFilamentPublishable\Filament\Forms\Components;

use Filament\Forms\Components\DateTimePicker;
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
        $this->hiddenOn('create');
        $this->hidden(function (Model $record) {
            /** @var Model&Publishable $record */
            return $this->isPublishable($record) && (! $record->{$record->getPublishedFirstAtColumn()} || ! $record->isPublished());
        });
        $this->rule('required');
        $this->required();
    }
}
