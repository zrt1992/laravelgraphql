<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //dd('laravel hadnler');
       // throw ValidationException::withMessages(['your error message']);

        $this->renderable(function (\Exception $e, $request) {

//            dd($e);

            if ($e instanceof CustomException) {
                $error['message'] = 'validation';
                $error['extensions'] = [
                    'category' => 'validation',
                    'validation' => $e->validator->errors()->getMessages(),
                ];
            }
            if ($e instanceof \ErrorException) {
                $error['message'] = 'validation';
                $error['extensions'] = [
                    'category' => 'validation',
                    'validation' => $e->validator->errors()->getMessages(),
                ];
            }
            if ($e instanceof ValidationException) {
                $error['message'] = 'validation';
                $error['extensions'] = [
                    'category' => 'validation',
                    'validation' => $e->validator->errors()->getMessages(),
                ];
            }
            $data['errors'][]=$error;
            return response()->json($data);


        });

    }
}
