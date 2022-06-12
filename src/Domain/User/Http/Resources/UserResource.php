<?php

namespace Domain\User\Http\Resources;

use Base\Concretes\BaseJsonResource;
use Carbon\Carbon;
use Domain\User\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @property string $email
 * @property int $id
 * @property string $password
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property User $createdBy
 * @property User $updatedBy
 * @property User $deletedBy
 * @property Carbon $created_at
 * @property mixed $name
 * @property float $revenue
 */
class UserResource extends BaseJsonResource
{
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return $this->withDefaults([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'since' => $this->created_at->format('Y-m-d'),
            'revenue' => $this->revenue,
        ]);
    }
}
