<?php

namespace App\Exceptions;

use Exception;
use GraphQL\Error\ClientAware;

class CustomException extends \Exception implements ClientAware
{
    public $is_success;
    public $message;
    public $code;
    public $data;
    public $exception;

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
//        dd('report');
    }
    public function getCategory() {
        return 'resource_not_found';
    }
    public function isClientSafe(): bool
    {
        return true;
    }
    public function __construct($message, $code, )
    {
        $this->message = $message;
        $this->code = $code;
    }
//    public function throwException()
//    {
//        $className = $this->exception;
//        $t = new \ReflectionClass( $className);
//        dd($t);
//      // throw ($this->exception);
//    }


    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function render($request)
//    {
//        return response()->json('errors.custom');
//    }
}
