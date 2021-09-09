<?php

use App\Contracts\BookingRepository;
use App\Contracts\Service\UserServiceContract;
use App\Contracts\UserRepository;
use App\Services\BookingService;
use App\Services\UserService;
use App\Validators\BookingValidator;
use App\Validators\UserValidator;
use Illuminate\Support\Collection;
use Mockery\Exception\InvalidCountException;
use Tests\TestCase;

class BookingTest extends TestCase
{
    protected $unitPrice;

    protected $bookingRepositoryMock;
    protected $bookingValidatorMock;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $roomServiceMock;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUserServiceWithValidationFailed()
    {
        $this->bookingValidatorMock = $this->app->make(BookingValidator::class);
        $this->userValidatorMock = $this->app->make(UserValidator::class);

        $this->bookingRepositoryMock = Mockery::mock(BookingRepository::class);
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);

        $userObject = new stdClass();
        $userObject->id = 1;
        $this->userServiceMock = new UserService($this->userRepositoryMock, $this->userValidatorMock);


        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock,
            $this->userServiceMock);

        $request = $this->createRequest([
            'first_name' => '123',
            'last_name'  => '321',
        ]);
        $response = $bookingService->bookRoom($request->all());
        $this->assertEquals('validation-error', $response['status']);
    }

    public function testBookingWithValidationFailed()
    {
        $this->bookingValidatorMock = $this->app->make(BookingValidator::class);
        $this->userValidatorMock = $this->app->make(UserValidator::class);

        $this->bookingRepositoryMock = Mockery::mock(BookingRepository::class);
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->userServiceMock = Mockery::mock(UserServiceContract::class);


        $userObject = new stdClass();
        $userObject->id = 1;

        $this->userServiceMock->shouldReceive('createOrFetchUser')->once()->andReturn([
            "status" => 'success',
            "data"   => $userObject
        ]);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock,
            $this->userServiceMock);

        $request = $this->createRequest([
            'first_name' => '123',
            'last_name'  => '321'
        ]);
        $response = $bookingService->bookRoom($request->all());
        $this->assertEquals('validation-error', $response['status']);
    }

    public function testBookingWithSuccess()
    {

        $this->bookingValidatorMock = $this->app->make(BookingValidator::class);
        $this->userValidatorMock = $this->app->make(UserValidator::class);

        $this->bookingRepositoryMock = Mockery::mock(BookingRepository::class);
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->userServiceMock = Mockery::mock(UserServiceContract::class);


        $userObject = new stdClass();
        $userObject->id = 1;

        $this->userServiceMock->shouldReceive('createOrFetchUser')->once()->andReturn([
            "status" => 'success',
            "data"   => $userObject
        ]);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock,
            $this->userServiceMock);

        $request = $this->createRequest([
            'first_name'       => '123',
            'last_name'        => '321',
            'reservation_date' => ["2021-09-12"]
        ]);

        $reservationObject = new stdClass();
        $reservationObject->user_id = 1;
        $reservationObject->isBooked = true;
        $reservationObject->reservation_date = "2021-09-12";

        $this->bookingRepositoryMock->shouldReceive('bookRoom')->once()->andReturn(new Collection([
            $reservationObject
        ]));
        $response = $bookingService->bookRoom($request->all());

        $this->assertEquals('success', $response['status']);
        $this->assertTrue($response['data']["2021-09-12"]);
    }

    public function testBookingWithFailed()
    {

        $this->bookingValidatorMock = $this->app->make(BookingValidator::class);
        $this->userValidatorMock = $this->app->make(UserValidator::class);

        $this->bookingRepositoryMock = Mockery::mock(BookingRepository::class);
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->userServiceMock = Mockery::mock(UserServiceContract::class);


        $userObject = new stdClass();
        $userObject->id = 1;

        $this->userServiceMock->shouldReceive('createOrFetchUser')->once()->andReturn([
            "status" => 'success',
            "data"   => $userObject
        ]);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock,
            $this->userServiceMock);

        $request = $this->createRequest([
            'first_name'       => '123',
            'last_name'        => '321',
            'reservation_date' => ["2021-09-12"]
        ]);

        $reservationObject = new stdClass();
        $reservationObject->user_id = 1;
        $reservationObject->isBooked = true;
        $reservationObject->reservation_date = "2021-09-12";

        $this->bookingRepositoryMock->shouldReceive('bookRoom')->once()->andReturn(new Collection());
        $response = $bookingService->bookRoom($request->all());
        $this->assertEquals('error', $response['status']);
    }

    public function testBookingWithUserCreationFailed()
    {

        $this->bookingValidatorMock = $this->app->make(BookingValidator::class);
        $this->userValidatorMock = $this->app->make(UserValidator::class);

        $this->bookingRepositoryMock = Mockery::mock(BookingRepository::class);
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);


        $userObject = new stdClass();
        $userObject->id = 1;

        $this->userRepositoryMock->shouldReceive('createOrFetchUser')->once()->andReturn(null);

        $this->userServiceMock = new UserService($this->userRepositoryMock, $this->userValidatorMock);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock,
            $this->userServiceMock);

        $request = $this->createRequest([
            'email'            => 'atik@gmail.com',
            'first_name'       => '123',
            'last_name'        => '321',
            'reservation_date' => ["2021-09-12"]
        ]);
        $response = $bookingService->bookRoom($request->all());
        $this->assertEquals('error', $response['status']);
    }



    protected function createRequest($data)
    {
        $request = new \Illuminate\Http\Request();
        $request->replace($data);
        return $request;
    }


}
