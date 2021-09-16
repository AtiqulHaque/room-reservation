<?php
namespace App\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

interface UserRepository extends RepositoryInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function createOrFetchUser(array $params = array());
}
