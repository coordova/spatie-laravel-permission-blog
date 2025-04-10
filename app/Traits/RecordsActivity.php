<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        static::created(function ($model) {
            $model->recordActivity('created');
        });

        static::updated(function ($model) {
            $model->recordActivity('updated');
        });
    }

    protected function recordActivity($event)
    {
        \App\Models\Activity::create([
            'user_id' => Auth::id(),
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'event' => $event,
            'description' => "{$event} on " . class_basename($this),
        ]);
    }
}
