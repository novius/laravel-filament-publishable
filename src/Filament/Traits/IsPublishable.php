<?php

namespace Novius\LaravelFilamentPublishable\Filament\Traits;

use Illuminate\Database\Eloquent\Model;
use Novius\LaravelPublishable\Traits\Publishable;

trait IsPublishable
{
    protected function isPublishable(Model $record): bool
    {
        return in_array(Publishable::class, class_uses_recursive($record), true);
    }
}
