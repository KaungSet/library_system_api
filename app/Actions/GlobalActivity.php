<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait GlobalActivity
{
    protected static function bootAction()
    {
        static::created(function ($model) {
            (new StoreActivityLog())->store(model: $model, title: class_basename(self::class) . ' Created', activity: 'Create');
        });

        static::updated(function ($model) {

            (new StoreActivityLog())->store(model: $model, title: class_basename(self::class) . ' Updated', activity: 'Update');
        });

        static::deleted(function ($model) {

            (new StoreActivityLog())->store(model: $model, title: class_basename(self::class) . ' Deleted', activity: 'Delete');
        });
    }
}
