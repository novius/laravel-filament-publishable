<?php

namespace Novius\LaravelFilamentPublishable\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Novius\LaravelFilamentPublishable\Filament\Traits\IsPublishable;
use Novius\LaravelPublishable\Traits\Publishable;

class PublicationColumn extends TextColumn
{
    use IsPublishable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('laravel-filament-publishable::messages.fields.publication_status'));
        $this->badge(function (Model $record): string {
            /** @var Model&Publishable $record */
            if ($this->isPublishable($record)) {
                if ($record->isPublished()) {
                    return 'success';
                }
                if ($record->willBePublished()) {
                    return 'warning';
                }
            }

            return 'danger';
        });
        $this->icon(function (Model $record): string {
            /** @var Model&Publishable $record */
            if ($this->isPublishable($record)) {
                if ($record->isPublished()) {
                    return 'heroicon-o-check';
                }
                if ($record->willBePublished()) {
                    return 'heroicon-o-clock';
                }
            }

            return 'heroicon-o-x-circle';
        });
        $this->formatStateUsing(function (Model $record): string {
            /** @var Model&Publishable $record */

            return $this->isPublishable($record) ? $record->publicationLabel() : '';
        });
    }
}
