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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'user_id', 'room_number', 'arrival', 'checkout', 'book_type', 'book_time'];


    public function room()
    {
        return $this->belongsTo(Room::class,'room_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'room_id', 'id');
    }
}
