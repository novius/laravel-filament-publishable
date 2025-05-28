<?php

namespace Novius\LaravelFilamentPublishable\Filament\Tables\Filters;

use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Novius\LaravelPublishable\Traits\Publishable;

class PublicationStatusFilter extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options([
            'published' => trans('laravel-filament-publishable::messages.filters.published'),
            'will-be-published' => trans('laravel-filament-publishable::messages.filters.will_be_published'),
            'not-published' => trans('laravel-filament-publishable::messages.filters.not_published'),
            'drafted' => trans('laravel-filament-publishable::messages.filters.drafted'),
            'expired' => trans('laravel-filament-publishable::messages.filters.expired'),
        ]);
        $this->modifyQueryUsing(function (Builder $query, array $data = []) {
            $isMultiple = $this->isMultiple();
            $values = Arr::wrap($isMultiple ? $data['values'] ?? null : $data['value'] ?? null);

            if (blank(array_filter($values))) {
                return $query;
            }
            $query->where(function (Builder $query) use ($values) {
                /** @var Builder<Publishable> $query */
                if (in_array('published', $values, true)) {
                    $query->orWhere(fn (Builder $query) => $query->published());
                }
                if (in_array('will-be-published', $values, true)) {
                    $query->orWhere(fn (Builder $query) => $query->onlyWillBePublished());
                }
                if (in_array('not-published', $values, true)) {
                    $query->orWhere(fn (Builder $query) => $query->notPublished());
                }
                if (in_array('drafted', $values, true)) {
                    $query->orWhere(fn (Builder $query) => $query->onlyDrafted());
                }
                if (in_array('expired', $values, true)) {
                    $query->orWhere(fn (Builder $query) => $query->onlyExpired());
                }
            });

            return $query;
        });
    }
}
