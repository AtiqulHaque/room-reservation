<?php

use App\Contracts\BookingRepository;
use App\Contracts\Service\BookingServiceContract;
use App\Contracts\Service\RoomServiceContarct;
use App\Services\BookingService;
use App\Services\RoomService;
use App\Validators\BookingValidator;
use Tests\TestCase;

class CheckOutTest extends TestCase
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
    public function testCheckOutWithSuccess()
    {
        $request = $this->createRequest([
            'room_id' => '123',
            'user_id' => '321',
        ]);

        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);

        $booking = new stdClass();
        $booking->isFullPayment = 1;

        $this->bookingRepositoryMock->shouldReceive('find')->once()->andReturn($booking);

        $bookingDetails = new stdClass();
        $bookingDetails->id = 123;

        $this->bookingRepositoryMock->shouldReceive('bookingDetailsByRoomId')->once()->withAnyArgs()->andReturn($bookingDetails);
        $this->bookingRepositoryMock->shouldReceive('checkOut')->once()->withAnyArgs()->andReturn([
            'success'
        ]);

        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);



        $response = $bookingService->checkOut($request->get('room_id'), $request->get('user_id'));

        $this->assertEquals('success', $response['status']);
    }


    public function testCheckOutWithError()
    {
        $request = $this->createRequest([
            'room_id' => '123',
            'user_id' => '321',
        ]);

        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);

        $booking = new stdClass();
        $booking->isFullPayment = 0;

        $this->bookingRepositoryMock->shouldReceive('find')->once()->andReturn($booking);

        $bookingDetails = new stdClass();
        $bookingDetails->id = 123;

        $this->bookingRepositoryMock->shouldReceive('bookingDetailsByRoomId')->once()->withAnyArgs()->andReturn($bookingDetails);



        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);



        $response = $bookingService->checkOut($request->get('room_id'), $request->get('user_id'));

        $this->assertEquals('error', $response['status']);
    }

    public function testCheckOutWithValidationError()
    {
        $request = $this->createRequest([
            'room_id' => '123',
            'user_id' => '321',
        ]);

        $this->bookingValidatorMock  = $this->app->make(BookingValidator::class);

        $this->bookingRepositoryMock =  Mockery::mock(BookingRepository::class);


        $this->roomServiceMock =  Mockery::mock(RoomServiceContarct::class);

        $bookingService = new BookingService($this->bookingRepositoryMock, $this->bookingValidatorMock, $this->roomServiceMock);



        $response = $bookingService->checkOut($request->get('room_id'), null);

        $this->assertEquals('validation-error', $response['status']);
    }

    protected function createRequest($data)
    {
        $request = new \Illuminate\Http\Request();
        $request->replace($data);
        return $request;
    }


}
