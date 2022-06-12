<?php

namespace App\Traits\Eloquent;

use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

trait DeletedBy
{
    use SoftDeletes;

    public static function bootDeletedBy(): void
    {
        static::deleting(function ($model) {
            $model = $model->forceFill([
                'deleted_by' => auth()->user()->getAuthIdentifier()
            ]);
            $model->save();
        });
    }

    public function deletedBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }
}
