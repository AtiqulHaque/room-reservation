<?php

namespace App\Repositories;

use App\Contracts\UserRepository;
use App\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\RoomRepository;
use App\Models\Room;
use App\Validators\RoomValidator;

/**
 * Class RoomRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function createOrFetchUser(array $params = array())
    {
        $user = $this->getUserByEmail($params['email']);
        if ($user) {
            $user->fill($params);
            $user->save();

        } else {
            $user = $this->model->create($params);
        }

        return $user;
    }

    private function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
