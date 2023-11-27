<?php

namespace App\Actions;

use App\Models\ActivityLog;

class StoreActivityLog
{
    public static function store($model, string $title, string $activity)
    {

        $log            = new ActivityLog();

        $log->createable_type = get_class(auth()->guard('api')->user() ?? $model);
        $log->createable_id = auth()->guard('api')->user()?->id;
        $log->title     = $title;
        $log->activity  = $activity;
        // $log->company_id = auth()->user()->company_id;

        $model->activityLogs()->save($log);

        return $log;
    }
}
