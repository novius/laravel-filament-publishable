<?php

namespace Novius\LaravelFilamentPublishable\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Enums\PublicationStatus;
use Novius\LaravelPublishable\Traits\Publishable;

class PublicationColumn extends TextColumn
{
    use IsPublishable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('laravel-filament-publishable::messages.fields.publication_status'));
        $this->badge();
        $this->color(fn (PublicationStatus $state) => Arr::get($this->publicationColors(), $state->value));
        $this->icon(fn (PublicationStatus $state) => Arr::get($this->publicationIcons(), $state->value));
        $this->formatStateUsing(function (Model $record): string {
            /** @var Model&Publishable $record */
            $model = $this->publishableModel($record);

            return $model ? $record->publicationLabel() : '';
        });
    }
}
