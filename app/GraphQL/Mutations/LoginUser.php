<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Exceptions\CustomException;
use App\GraphQL\Middleware\LoginCheck;
use App\Http\Middleware\Login;
use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use function Laravel\Prompts\error;

class LoginUser extends Mutation
{
    protected $attributes = [
        'name' => 'loginUser',
        'description' => 'A mutation'
    ];
    protected $middleware = [
//        LoginCheck::class
   // Login::class
    ];
//    protected function getMiddleware(): array
//    {
//        return (array_merge([],$this->middleware));
//    }

    public function type(): Type
    {
        return GraphQL::type("LoginUser");
    }

    public function args(): array
    {
        return [

            'email' => [
                "name" => "email",
                "type" => Type::string()
            ],
            'password' => [
                "name" => "password",
                "type" => Type::string()
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        $user = User::where('email', $args['email'])->first();
        if (! $user || ! Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages(['creds not valid']);
        }
        return collect([
            "user" => $user,
            'id' => $user->id,
            "token" => $user->createToken('App')->plainTextToken
        ]);
    }
}
