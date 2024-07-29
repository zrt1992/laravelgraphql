<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
class RegisterUser extends GraphQLType
{
    protected $attributes = [
        'name' => 'RegisterUser',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            "name" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ],
            "email" => [
                "type" => Type::string(),
                "description" => "User email",
            ],
            "password" => [
                "type" => Type::string(),
                "description" => "User email",
            ]
        ];
    }
}
