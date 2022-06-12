<?php

namespace Domain\Order\Http\Resources;

use Base\Concretes\BaseJsonResource;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @property string $reason
 * @property array $rules
 * @property int $id
 */
class DiscountResource extends BaseJsonResource
{
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return $this->withDefaults([
            'id' => $this->id,
            'reason' => $this->reason,
            'rules' => $this->rules,
        ]);
    }
}
