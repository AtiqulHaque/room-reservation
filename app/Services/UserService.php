<?php


namespace App\Services;


use App\Contracts\Service\UserServiceContract;
use App\Contracts\UserRepository;
use App\Validators\UserValidator;

class UserService implements  UserServiceContract
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepo, UserValidator $validator)
    {
        $this->userRepository = $userRepo;
        $this->validator = $validator;
    }

    /**
     * @param $params
     * @return array|mixed
     */
    public function createOrFetchUser($params)
    {
        $this->validator->setRegisterRules();

        if (!$this->validator->with($params)->passes()) {
            return [
                'html'   => "Register validation errors",
                'status' => 'validation-error',
                'error'  => $this->validator->errors()->messages()
            ];
        }

        $responseUser = $this->userRepository->createOrFetchUser($params);

        if(!empty($responseUser)){
            return [
                "status" => 'success',
                'data' => $responseUser
            ];
        } else{
            return [
                "status" => 'error',
                'data' => $responseUser
            ];
        }

    }
}
