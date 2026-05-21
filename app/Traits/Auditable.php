<?php

namespace App\Traits;

use App\Models\Audit;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            static::createAudit($model, 'create', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            $oldValues = $model->getOriginal();
            static::createAudit($model, 'update', $oldValues, $changes);
        });

        static::deleted(function ($model) {
            static::createAudit($model, 'delete', $model->getAttributes(), null);
        });
    }

    protected static function createAudit($model, $action, $oldValues, $newValues)
    {
        Audit::create([
            'user_name' => auth()->check() ? auth()->user()->name : 'System',
            'model_type' => class_basename($model),
            'model_id' => $model->id,
            'action' => $action,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}