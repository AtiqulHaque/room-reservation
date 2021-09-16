<?php

namespace App\Repositories;

use App\Contracts\BookingRepository;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BookingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookingRepositoryEloquent extends BaseRepository implements BookingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Booking::class;
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
     * @return Collection|mixed
     */
    public function bookRoom(array $params = array())
    {
        DB::beginTransaction();
        $reservation = collect();
        try {
            $reservation = $this->model->where('isBooked', Booking::IS_FREE)
                ->whereIn('reservation_date', $params['reservation_date'])
                ->lockForUpdate()
                ->get();
            //sleep(20);
            if (!empty($reservation) && $reservation instanceof Collection && $reservation->count() > 0) {
                $reservation->each(function ($eachData) use ($params) {
                    $eachData->user_id = $params['user_id'];
                    $eachData->booking_date = Carbon::now();
                    $eachData->isBooked = Booking::IS_BOOKED;
                    $eachData->save();
                });
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error occurred while booking", [$e]);
        }

        DB::commit();

        return $reservation;
    }


    /**
     * @param $bookingId
     * @return mixed
     */
    public function bookingDetails($bookingId)
    {
        return $this->model->where('id', $bookingId)
            ->with(['room'])
            ->first();
    }

    /**
     * @return mixed
     */
    public function getBookingList()
    {
        return $this->with([
            'room',
            'user'
        ])->paginate();
    }

    /**
     * @param $bookingId
     * @return mixed
     */
    public function bookingDetailsById($bookingId)
    {
        return $this->model->where('id', $bookingId)
            ->first();
    }

    /**
     * @param null $startDate
     * @return mixed
     */
    public function getBookingListByMonth($startDate = null)
    {
        return $this->model->where('isBooked', true)->get();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function roomAvailabilityCheck(array $params = array())
    {
        return $this->model->whereIn('reservation_date', $params['reservation_date'])
            ->get();
    }
}
