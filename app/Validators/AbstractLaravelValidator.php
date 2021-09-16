<?php
namespace App\Validators;

use Illuminate\Validation\Factory as Validator;

class AbstractLaravelValidator extends Validator
{
    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Validation data key => value array
     *
     * @var Array
     */
    protected $data = array();

    /**
     * Validation errors
     *
     * @var Array
     */
    protected $errors = array();

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array();

    /**
     * Custom validation messages
     *
     * @var Array
     */
    protected $messages = array();

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }
    /**
     * Validation passes or fails
     *
     * @return Boolean
     */

    public function passes()
    {
        $validator = $this->validator->make(
            $this->data,
            $this->rules,
            $this->messages
        );
        if ($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }
        return true;
    }
    /**
     * Return errors, if any
     * *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
}
