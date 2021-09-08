<?php

namespace App\Validators;


class BookingValidator extends AbstractLaravelValidator
{

    public function setBookingRules()
    {
        $this->rules = array(
            'reservation_date' => 'required|array',
            'user_id' => 'required'
        );
    }

    public function setBookingDetailsRules()
    {
        $this->rules = array(
            'booking_id' => 'required|digits_between:1,1000000000'
        );
    }

}
