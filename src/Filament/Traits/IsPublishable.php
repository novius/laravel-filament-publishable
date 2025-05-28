<?php

namespace Novius\LaravelFilamentPublishable\Filament\Traits;

use Illuminate\Database\Eloquent\Model;
use Novius\LaravelPublishable\Traits\Publishable;

trait IsPublishable
{
    /**
     * @param  class-string<Model>|Model  $model
     */
    protected function isPublishable(string|Model $model): bool
    {
        return in_array(Publishable::class, class_uses_recursive($model), true);
    }

    /**
     * @return Model&Publishable
     */
    protected function publishableModel(string $modelClass): Model
    {
        return new $modelClass;
    }
}
