<?php

namespace Novius\LaravelFilamentPublishable\Filament\Traits;

use Exception;
use Filament\Forms\Components\Field;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Model;
use Novius\LaravelPublishable\Enums\PublicationStatus as PublicationStatusEnum;
use Novius\LaravelPublishable\Traits\Publishable;

trait IsPublishable
{
    /**
     * @return Model&Publishable|null
     *
     * @throws Exception
     */
    protected function publishableModel($modelClass = null): ?Model
    {
        if ($this instanceof Field) {
            $modelClass = $this->getModel();
        } elseif ($this instanceof Column || $this instanceof BaseFilter || $this instanceof BulkAction) {
            $modelClass = $this->getTable()->getModel();
        }
        if ($modelClass !== null && in_array(Publishable::class, class_uses_recursive($modelClass), true)) {
            return new $modelClass;
        }

        return null;
    }

    protected function publicationIcons(): array
    {
        return [
            PublicationStatusEnum::draft->value => 'heroicon-o-pencil',
            PublicationStatusEnum::published->value => 'heroicon-o-check',
            PublicationStatusEnum::unpublished->value => 'heroicon-o-x-mark',
            PublicationStatusEnum::scheduled->value => 'heroicon-o-clock',
        ];
    }

    protected function publicationColors(): array
    {
        return [
            PublicationStatusEnum::draft->value => 'gray',
            PublicationStatusEnum::published->value => 'success',
            PublicationStatusEnum::unpublished->value => 'warning',
            PublicationStatusEnum::scheduled->value => 'info',
        ];
    }
}
