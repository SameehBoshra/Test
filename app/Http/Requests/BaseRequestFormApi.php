<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator as LaravelValidator;

abstract class BaseRequestFormApi
{
    protected $request;
    protected $status = true;
    protected $errors = [];

    /**
     * Force child classes to define validation rules.
     */
    abstract public function rules(): array;

    /**
     * Constructor to validate the request.
     */
    public function __construct(?Request $request = null , bool $forceDie = true)
    {
        if (!is_null($request)) {
            $this->request = $request;
            $rules = $this->rules();

            $validator = LaravelValidator::make($request->all(), $rules);

            if ($validator->fails()) {
                $this->status = false;
                $this->errors = $validator->errors()->toArray();

                if ($forceDie) {
                    throw new HttpResponseException(response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors'  => $this->errors,
                    ], 422));
                }
            }
        }
    }

    /**
     * Get request status.
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * Get validation errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

/*     public function validated(): array
{
    return $this->request->all();
} */

public function request(): Request
{
    return $this->request;
}
}
