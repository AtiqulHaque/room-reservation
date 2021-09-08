<?php

namespace App\Validators;


class BookingValidator extends AbstractLaravelValidator
{

    public function setBookingRules()
    {
        $this->rules = array(
            'room_id' => 'required',
            'user_id' => 'required',
            'room_number' => 'required',
        );
    }
    public function setCherckIn()
    {
        $this->rules = array(
            'room_id' => 'required',
            'user_id' => 'required'
        );
    }
    public function setCherckOut()
    {
        $this->rules = array(
            'room_id' => 'required',
            'user_id' => 'required'
        );
    }

}
