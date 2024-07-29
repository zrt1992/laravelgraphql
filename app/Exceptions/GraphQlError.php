<?php

namespace App\Exceptions;

use GraphQL\Error\DebugFlag;
use GraphQL\Error\Error;
use GraphQL\Error\FormattedError;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Rebing\GraphQL\Error\AuthorizationError;
use Rebing\GraphQL\Error\ProvidesErrorCategory;
use Rebing\GraphQL\Error\ValidationError;

class GraphQlError extends \GraphQL\Error\Error
{
    public static function formatError(Error $e): array
    {
//        dd('formatter');
        $debug = Config::get('app.debug') ? (DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE) : DebugFlag::NONE;
        $formatter = FormattedError::prepareFormatter(null, $debug);
        $error = $formatter($e);
        $data = [];
        $previous = $e->getPrevious();

        // dd($e->getPrevious());
        // dd($previous->data);
        if ($previous) {
//               dd($previous);
            if ($previous instanceof CustomException) {
                $data['message'] = 'Custom';
                $data['extensions'] = [
                    'category' => 'validation',
                    'validation' => $previous->message,
                ];

            }
            if ($previous instanceof JsonEncodingException) {
                $data['extensions'] = [
                    'category' => 'validation',
                    'validation' => $previous->message,
                ];
            }
            if ($previous instanceof ValidationException) {
                $data['message'] = 'validation';
                $data['extensions'] = [
                    'category' => 'validation',
                    'validation' => $previous->validator->errors()->getMessages(),
                ];
            }

            if ($previous instanceof ValidationError) {
                $data['extensions']['validation'] = $previous->getValidatorMessages()->getMessages();
            }

            if ($previous instanceof ProvidesErrorCategory) {

                $data['extensions']['category'] = $previous->getCategory();
                $data['extensions']['validation'] = $previous->message;
            }
        } elseif ($e instanceof ProvidesErrorCategory) {
            $data['extensions']['category'] = $e->getCategory();
        } else {

            $data['extensions']['category'] = 'validation';
            $data['extensions']['validation'] = $previous->message;
        }

        return $data;
    }

    public static function handleErrors(array $errors, callable $formatter): array
    {
        $handler = app()->make(ExceptionHandler::class);

        foreach ($errors as $error) {
            // Try to unwrap exception
            $error = $error->getPrevious() ?: $error;

            // Don't report certain GraphQL errors
            if ($error instanceof ValidationError ||
                $error instanceof AuthorizationError ||
                !(
                    $error instanceof Exception ||
                    $error instanceof PhpError
                )) {
                continue;
            }

            if (!$error instanceof Exception) {
                $error = new Exception(
                    $error->getMessage(),
                    $error->getCode(),
                    $error
                );
            }

            $handler->report($error);
        }

        return array_map($formatter, $errors);
    }

}
