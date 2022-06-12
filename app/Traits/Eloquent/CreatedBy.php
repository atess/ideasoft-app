<?php

namespace App\Traits\Eloquent;

use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

trait CreatedBy
{
    public static function bootCreatedBy(): void
    {
        static::creating(function (Model $model) {
            $model->forceFill([
                'created_by' => Auth::id()
            ]);
        });
    }

    public function createdBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
