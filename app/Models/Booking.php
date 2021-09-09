<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Booking.
 *
 * @package namespace App\Models;
 */
class Booking extends Model implements Transformable
{
    use TransformableTrait;

    const IS_BOOKED = true;
    const IS_FREE = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'isBooked', 'reservation_date', 'booking_date'];


    public function user()
    {
        return $this->belongsTo(User::class, 'room_id', 'id');
    }
}
