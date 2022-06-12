<?php

namespace Domain\User\Models;

use App\Traits\Eloquent\UnsetWheres;
use App\Traits\Eloquent\CreatedBy;
use App\Traits\Eloquent\DeletedBy;
use App\Traits\Eloquent\UpdatedBy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

/**
 * @property int $id
 * @property Carbon $created_at
 */
class User extends Authenticatable
{
    use HasApiTokens, UnsetWheres, HasFactory, Notifiable;
    use CreatedBy, UpdatedBy, DeletedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'revenue',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Str::title($value),
        );
    }
}
