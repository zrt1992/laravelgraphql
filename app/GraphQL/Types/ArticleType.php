<?php
declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Article;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ArticleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Articles',
        'description' => 'A type definition for the Articles Model',
        'model' => Article::class
    ];

    public function fields(): array
    {
        return [
//            'id' => [
//                'type' => Type::nonNull(Type::id()),
//                'description' => 'The auto incremented Article ID'
//            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'A title of the Article'
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The Body of the Article'
            ]
        ];
    }
}
