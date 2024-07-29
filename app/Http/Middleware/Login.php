<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Closure;
use GraphQL\Error\Error;
use GraphQL\Executor\ExecutionResult;
use GraphQL\Language\AST\OperationDefinitionNode;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Schema;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\AuthenticateSession;
use Rebing\GraphQL\Support\ExecutionMiddleware\AbstractExecutionMiddleware;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Middleware;
use Rebing\GraphQL\Support\OperationParams;
use Symfony\Component\HttpFoundation\Response;
use \Rebing\GraphQL\Support\ExecutionMiddleware\UnusedVariablesMiddleware;
use Rebing\GraphQL\Support\ExecutionMiddleware\GraphqlExecutionMiddleware;
class Login extends Middleware
{
    public function handle($root, array $args, $context, ResolveInfo $info, Closure $next)
    {
        return $next($root, $args, $context, $info);
    }


}
