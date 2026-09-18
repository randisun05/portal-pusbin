<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Auditable;

class PengaturanChat extends Model
{
    use Auditable;

    protected $guarded = ['id'];

    const PROVIDER_CLAUDE = 'claude';
    const PROVIDER_GEMINI = 'gemini';

    public static function providers(): array
    {
        return [
            self::PROVIDER_CLAUDE => 'Claude (Anthropic)',
            self::PROVIDER_GEMINI => 'Gemini (Google)',
        ];
    }

    public static function current()
    {
        return static::first() ?? static::create([
            'provider' => self::PROVIDER_CLAUDE,
        ]);
    }
}
