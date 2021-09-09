<?php
namespace App\Contracts\Service;

interface UserServiceContract
{
    /**
     * @param $params
     * @return mixed
     */
    public function createOrFetchUser($params);
}
