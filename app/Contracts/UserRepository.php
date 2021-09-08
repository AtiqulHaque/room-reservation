<?php
namespace App\Contracts;


use Prettus\Repository\Contracts\RepositoryInterface;

interface UserRepository extends RepositoryInterface
{
    public function createUser( array $params = array());
}
