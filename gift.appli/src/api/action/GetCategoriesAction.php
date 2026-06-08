<?php

declare(strict_types=1);

namespace gift\appli\api\action;

use gift\appli\application_core\application\usecases\CatalogueService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetCategoriesAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $service = new CatalogueService();
        $categories = $service->getCategories();

        $tab = [];
        foreach ($categories as $categorie) {
            $tab[] = [
                'categorie' => [
                    'id' => $categorie['id'],
                    'libelle' => $categorie['libelle'],
                    'description' => $categorie['description'],
                ],
                'links' => [
                    'self' => [
                        'href' => '/categories/' . $categorie['id'] . '/',
                    ],
                ], 
            ];
        }


        $data = [
            'type' => 'collection',
            'count' => count($tab),
            'categories' => $tab,
        ];

        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}