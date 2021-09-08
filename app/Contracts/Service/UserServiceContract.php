<?php

namespace App\Contracts\Service;


interface UserServiceContract
{
    public function createOrFetchUser($params);
}
