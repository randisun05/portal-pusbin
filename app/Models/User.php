<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Concerns\Auditable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];


    protected $guarded =['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_enabled_at' => 'datetime',
        'two_factor_secret' => 'encrypted',
        'two_factor_recovery_codes' => 'encrypted:array',
    ];

    public function hasTwoFactorEnabled(): bool
    {
        return ! is_null($this->two_factor_enabled_at) && ! is_null($this->two_factor_secret);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(...$names)
    {
        return $this->role && in_array($this->role->name, $names);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole(Role::SUPER_ADMIN);
    }

    public function hasPermission(string $slug): bool
    {
        // Pengguna tanpa role (mis. dibuat sebelum fitur role ada) tetap
        // diperlakukan tidak dibatasi, konsisten dengan EnsureRole.
        if (! $this->role_id) {
            return true;
        }

        return $this->role->hasPermission($slug);
    }

}
