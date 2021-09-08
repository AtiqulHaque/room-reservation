<?php

use App\Contracts\BookingRepository;
use App\Contracts\Service\RoomServiceContarct;
use App\Services\BookingService;
use App\Services\RoomService;
use App\Validators\BookingValidator;
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

    public  function setUp(): void
    {
        parent::setUp();
    }
    public function testBookingFareWithSuccess()
    {
        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);

        $this->bookingRepositoryMock->shouldReceive('bookRoom')->once()->andReturn([
            'success'
        ]);


        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $roomObject = new stdClass();
        $roomObject->roomNumber = "1234";

        $this->roomServiceMock->shouldReceive('roomDetails')->once()->andReturn($roomObject);


        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);

        $request = $this->createRequest([
            'room_id' => '123',
            'user_id' => '321',
            'room_number' => '321',
        ]);
        $response = $bookingService->bookRoom($request->all());

        $this->assertEquals('success', $response['status']);
    }

    public function testBookingFareWithValidationError()
    {
        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);

        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);

        $request = $this->createRequest([
            'user_id' => '321',
            'room_number' => '321',
        ]);
        $response = $bookingService->bookRoom($request->all());

        $this->assertEquals('validation-error', $response['status']);
    }

    public function testBookingFareWithError()
    {
        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);

        $this->bookingRepositoryMock->shouldReceive('bookRoom')->once()->andReturn([]);


        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $roomObject = new stdClass();
        $roomObject->roomNumber = "1234";

        $this->roomServiceMock->shouldReceive('roomDetails')->once()->andReturn($roomObject);


        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);

        $request = $this->createRequest([
            'room_id' => '123',
            'user_id' => '321',
            'room_number' => '321',
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
