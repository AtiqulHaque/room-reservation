<?php
namespace App\Validators;

class UserValidator extends AbstractLaravelValidator
{

    public function setRegisterRules()
    {
        $this->rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        );
    }
}
