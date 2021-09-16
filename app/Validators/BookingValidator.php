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

    public function setAvailabilityRules()
    {
        $this->rules = array(
            'reservation_date' => 'required|array'
        );
    }
}
