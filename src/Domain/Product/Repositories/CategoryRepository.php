<?php

namespace Domain\Product\Repositories;

use Base\Concretes\BaseRepository;
use Domain\Product\Contracts\Repositories\CategoryRepositoryInterface;
use Domain\Product\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
