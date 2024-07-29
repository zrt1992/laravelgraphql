<?php

declare(strict_types=1);

namespace App\GraphQL\Middleware;

use App\Exceptions\CustomException;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Rebing\GraphQL\Support\Middleware;
use Illuminate\Auth\Middleware\Authenticate as LaravelMiddleware;
use Symfony\Component\HttpFoundation\Response;

class LoginCheck
{
//    public function handle($root, array $args, $context, ResolveInfo $info, Closure $next)
//    {
//        if (!auth('sanctum')->check()) {
//            throw new CustomException('Your Creds are not valid', 401);
//        }
//        return $next($root, $args, $context, $info);
//    }
    public function handle(Request $request, Closure $next): Response
    {
//        throw new CustomException('Your Creds are not valid', 401);
//        throw  ValidationException::withMessages(['asd']);
//
        if (!auth('sanctum')->check()) {
            throw  ValidationException::withMessages(['you are not authenticated']);
        }

        return $next($request);
    }
}
