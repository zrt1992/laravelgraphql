<?php
declare(strict_types=1);
namespace App\GraphQL\Mutations;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class RegisterUser extends Mutation
{
    protected $attributes = [
        'name' => 'registerUser',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type("RegisterUser");
    }

    public function args(): array
    {
        return [
            'name' => [
                "name" => "name",
                "type" => Type::string(),
            ],
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

    public function rules(array $args = []): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ];
    }
    public function validationErrorMessages(array $args = []): array
    {
        return [
            'name.required' => 'Please enter your full name',
            'name.string' => 'Your name must be a valid string',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'Sorry, this email address is already in use',
        ];
    }
    public function validationAttributes(array $args = []): array
    {
        return [
            'email' => 'email address',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = User::create([
            'name' =>$args['name'],
            'email' =>$args['email'],
            'password' => bcrypt($args['password'])
        ]);

        return $user;
    }
}
