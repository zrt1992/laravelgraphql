<?php

namespace App\Http\Controllers;

use GraphQL\Server\OperationParams as BaseOperationParams;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laragraph\Utils\RequestParser;
use Rebing\GraphQL\GraphQL;
use Rebing\GraphQL\GraphQLController;
use Rebing\GraphQL\Helpers;
use Rebing\GraphQL\Support\OperationParams;

class TestController extends GraphQLController
{
    public function query(Request $request, RequestParser $parser, Repository $config, GraphQL $graphql): JsonResponse
    {
        $routePrefix = $config->get('graphql.route.prefix', 'graphql');
        $schemaName = $this->findSchemaNameInRequest($request, "/$routePrefix") ?: $config->get('graphql.default_schema', 'default');

        $operations = $parser->parseRequest($request);

        $headers = $config->get('graphql.headers', []);
        $jsonOptions = $config->get('graphql.json_encoding_options', 0);

        $isBatch = \is_array($operations);

        $supportsBatching = $config->get('graphql.batching.enable', true);

        if ($isBatch && !$supportsBatching) {
//            dd('ho');
            $data = $this->createBatchingNotSupportedResponse($request->input());


            return response()->json($data, 200, $headers, $jsonOptions);
        }

        $data = Helpers::applyEach(
            function (BaseOperationParams $baseOperationParams) use ($schemaName, $graphql): array {
                $operationParams = new OperationParams($baseOperationParams);

                return $graphql->execute($schemaName, $operationParams);
            },
            $operations
        );
//        dd($data);

        return response()->json($data, 200, $headers, $jsonOptions);
    }

}
