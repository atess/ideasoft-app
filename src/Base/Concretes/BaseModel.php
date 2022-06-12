<?php

namespace Base\Concretes;

use App\Traits\Eloquent\UnsetWheres;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory, UnsetWheres;
}
