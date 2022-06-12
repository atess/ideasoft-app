<?php
namespace Domain\User\Repositories\Caches;

use Base\Concretes\BaseCacheDecorator;
use Domain\User\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserCacheDecorator extends BaseCacheDecorator implements UserRepositoryInterface
{
    public function findMail(string $email): Model|null
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
