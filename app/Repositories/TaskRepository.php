<?php

namespace App\Repositories;

use App\Model\User;
use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function findOneByUser(User $user, $id)
    {
        if ($user->getIsAdmin()) {
            return $this->findOneBy(['id' => $id]);
        } else {
            return $this->findOneBy(['user' => $user, 'id' => $id]);
        }
    }
}
