<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Article;
use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class usersQuery extends Query
{
    protected $attributes = [
        'name' => 'UserList',
        'description' => 'A query for fetching a single article'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('UserList'));
//        return GraphQL::type('Articles');
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        return User::all();

       // return Article::where('id',1)->get()->first();
    }
}
