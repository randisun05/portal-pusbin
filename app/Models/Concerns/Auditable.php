<?php

namespace App\Models\Concerns;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            AuditLog::record('created', class_basename($model) . ' "' . $model->auditLabel() . '" dibuat', class_basename($model), $model->getKey());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            foreach (['updated_at', 'password', 'remember_token', 'email_verified_at'] as $hidden) {
                unset($changes[$hidden]);
            }
            if (empty($changes)) {
                return;
            }
            AuditLog::record('updated', class_basename($model) . ' "' . $model->auditLabel() . '" diubah', class_basename($model), $model->getKey(), $changes);
        });

        static::deleted(function ($model) {
            AuditLog::record('deleted', class_basename($model) . ' "' . $model->auditLabel() . '" dihapus', class_basename($model), $model->getKey());
        });
    }

    public function auditLabel()
    {
        foreach (['nama', 'title', 'name', 'label', 'isi'] as $field) {
            if (! empty($this->{$field})) {
                return \Illuminate\Support\Str::limit($this->{$field}, 60);
            }
        }

        return '#' . $this->getKey();
    }
}
