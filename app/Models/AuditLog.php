<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record($action, $description, $model = null, $modelId = null, $changes = null)
    {
        return static::create([
            'user_id' => auth()->id(),
            'user_name' => optional(auth()->user())->name ?? 'Tamu/Publik',
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
            'changes' => $changes ? json_encode($changes) : null,
            'ip_address' => request()->ip(),
            'url' => request()->fullUrl(),
        ]);
    }
}
