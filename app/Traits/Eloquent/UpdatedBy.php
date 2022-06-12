<?php

namespace App\Traits\Eloquent;

use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

trait UpdatedBy
{
    public static function bootUpdatedBy(): void
    {
        static::updating(function ($model) {
            $model->forceFill([
                'updated_by' => Auth::id()
            ]);
        });
    }

    public function updatedBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
