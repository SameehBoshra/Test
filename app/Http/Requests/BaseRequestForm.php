<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

abstract class BaseRequestForm
{
    protected $request;
    protected $errors = [];
    protected $status = true;

    /**
     * Force all child classes to define validation rules.
     */
    abstract public function rules(): array;

    /**
     * Constructor automatically validates the request.
     */
    public function __construct(?Request $request =null ,bool $forceDie = true)
    {
        if (!is_null($request)) {
            $this->request = $request;
            $rules = $this->rules();

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                if ($forceDie) {
                    $errorMessages = $validator->errors()->toArray();
                    throw ValidationException::withMessages($errorMessages);
                } else {
                    $this->status = false;
                    $this->errors = $validator->errors()->toArray();
                }
            }
        }
    }

    /**
     * Returns request errors if validation fails.
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Checks if validation passed or failed.
     */
    public function isValid(): bool
    {
        return $this->status;
    }

    public function validated(): array
    {
        return $this->request->all();
    }

    public function request(): Request
    {
        return $this->request;
    }
}
