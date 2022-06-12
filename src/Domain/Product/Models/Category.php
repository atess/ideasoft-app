<?php

namespace Domain\Product\Models;

use App\Traits\Eloquent\CreatedBy;
use App\Traits\Eloquent\DeletedBy;
use App\Traits\Eloquent\UpdatedBy;
use Base\Concretes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel
{
    use HasFactory;
    use CreatedBy, UpdatedBy, DeletedBy;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
    ];
}
