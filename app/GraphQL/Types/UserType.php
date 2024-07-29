<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use \App\Models\User as UserModel;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A type',
        'model' => UserModel::class
    ];

    public function fields(): array
    {
        return [
            "id" => [
                "type" => Type::id(),
                "description" => "Name of id",
            ],
            "name" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ],
            "email" => [
                "type" => Type::string(),
                "description" => "User email",
            ],
            'articles' => [
                "type" =>  Type::listOf(GraphQL::type('Articles'))
            ]
        ];
    }
}
