<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL as FacadesGraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
class LoginUser extends GraphQLType
{
    protected $attributes = [
        'name' => 'LoginUser',
        'description' => 'A type'
    ];
    public function type(): Type
    {
        return GraphQL::type("User");
    }

    public function fields(): array
    {
        return [
            "user" => [
                'type' => FacadesGraphQL::type('User'),
                'description' => "user"
            ],
            "token" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ]
        ];
    }
}
