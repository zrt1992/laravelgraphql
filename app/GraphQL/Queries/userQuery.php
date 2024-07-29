<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Exceptions\CustomException;
use App\GraphQL\Middleware\LoginCheck;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Middleware\Login;
use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;


class userQuery extends Query
{
    protected $middleware = [
        Login::class
    ];

    protected $attributes = [
        'name' => 'users',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id'=>[
                'name'=>'id',
                'type'=>Type::nonNull(Type::int())
            ],
        ];
    }
    protected function getMiddleware(): array
    {
        return (array_merge([],$this->middleware));
    }
//    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
//    {
//        if (isset($args['id'])) {
//            return Auth::id() == $args['id'];
//        }
//
//        return true;
//    }
//
//    public function getAuthorizationMessage(): string
//    {
//        return 'zulfiqar are not authorized to perform this action';
//    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields,Request $request)
    {
        //throw new CustomException('asdasd');
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

//        return User::all();
        return User::select($select)->with($with)->findOrFail($args['id']);
    }
}
