<?php

namespace App\Repositories;

use App\Contracts\UserRepository;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
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
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $params
     * @return mixed|null
     */
    public function createOrFetchUser(array $params = array())
    {
        DB::beginTransaction();
        $user = null;
        try {
            $user = $this->getUserByEmail($params['email']);
            if ($user) {
                $user->fill($params);
                $user->save();
            } else {
                $user = $this->model->create($params);
            }
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error("Error occurred while booking", [$e]);
        }

        DB::commit();
        return $user;
    }

    /**
     * @param $email
     * @return mixed
     */
    private function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
