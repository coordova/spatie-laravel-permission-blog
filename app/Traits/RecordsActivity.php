<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        static::created(function ($model) {
            $model->recordActivity('created');
        });

        static::updated(function ($model) {
            $model->recordActivity('updated', $model->getChanges());
        });

        static::deleted(function ($model) {
            $model->recordActivity('deleted');
        });

        /*static::restored(function ($model) {
            $model->recordActivity('restored');
        });*/
    }

    protected function recordActivity($event, $changes = null)
    {
        $user = Auth::user();

        $this->activities()->create([
            'user_id' => $user?->id,
            'ip_address' => Request::ip(),
            'event' => $event,
            'description' => $this->getActivityDescription($event),
            'changes' => $changes ? json_encode($changes) : null,
        ]);
    }

    protected function getActivityDescription($event)
    {
        return Str::title($event) . ' on ' . class_basename($this);
    }

    public function activities()
    {
        return $this->morphMany(\App\Models\Activity::class, 'subject');
    }
}
