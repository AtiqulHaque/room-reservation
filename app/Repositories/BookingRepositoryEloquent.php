<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\BookingRepository;
use App\Models\Booking;
use App\Validators\BookingValidator;

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

    public function bookRoom(array $params = array())
    {
        DB::beginTransaction();
        $reservation = null;
        try{
            $reservation = $this->model->where('isBooked', Booking::IS_FREE)
                ->whereIn('reservation_date', $params['reservation_date'])
                ->lockForUpdate()
                ->get();
            //sleep(20);
            if(!empty($reservation) && $reservation instanceof Collection && $reservation->count() > 0){
                $reservation->each(function ($eachData) use ($params){
                    $eachData->user_id = $params['user_id'];
                    $eachData->booking_date = Carbon::now();
                    $eachData->isBooked = Booking::IS_BOOKED;
                    $eachData->save();

                });

            }

        } catch(\Exception $e){
            DB::rollBack();
        }

        DB::commit();

        return $reservation;
    }



    public function bookingDetails($bookingId)
    {
        return $this->model->where('id', $bookingId)
            ->with(['room'])
            ->first();
    }

    public function getBookingList()
    {
        return $this->with([
            'room',
            'user'
        ])->paginate();
    }

    public function bookingDetailsById($bookingId)
    {
        return $this->model->where('id', $bookingId)
            ->first();
    }

    public function getBookingListByMonth($startDate = null)
    {
       return $this->all();
    }
}
