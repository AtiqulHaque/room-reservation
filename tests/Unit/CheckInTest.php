<?php

use App\Contracts\BookingRepository;
use App\Contracts\Service\RoomServiceContarct;
use App\Services\BookingService;
use App\Services\RoomService;
use App\Validators\BookingValidator;
use Tests\TestCase;

class CheckInTest extends TestCase
{
    protected $unitPrice;

    protected $bookingRepositoryMock;
    protected $bookingValidatorMock;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $roomServiceMock;

    public  function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testCheckInWithSuccess()
    {
        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);

        $this->bookingRepositoryMock->shouldReceive('checkIn')->once()->andReturn([
            'success'
        ]);


        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);

        $request = $this->createRequest([
            'room_id' => '123',
            'user_id' => '321',
        ]);

        $response = $bookingService->checkIn($request->get('room_id'), $request->get('user_id'));

        $this->assertEquals('success', $response['status']);
    }

    public function testCheckInWithValidationError()
    {
        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);

        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);

        $request = $this->createRequest([
            'user_id' => '321'
        ]);
        $response = $bookingService->checkIn($request->get('user_id'), null);

        $this->assertEquals('validation-error', $response['status']);
    }

    public function testBookingFareWithError()
    {
        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);

        $this->bookingRepositoryMock->shouldReceive('checkIn')->once()->andReturn([]);


        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);

        $request = $this->createRequest([
            'room_id' => '123',
            'user_id' => '321',
        ]);

        $response = $bookingService->checkIn($request->get('user_id'), $request->get('room_id'));

        $this->assertEquals('error', $response['status']);
    }

    protected function createRequest($data)
    {
        $request = new \Illuminate\Http\Request();
        $request->replace($data);
        return $request;
    }


}
