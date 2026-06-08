<?php

declare(strict_types=1);

namespace gift\appli\api\action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\usecases\BoxMangementService;

class GetBoxAction
{
    private BoxMangementService $boxMangementService;
    public function __construct()
    {
        $this->boxMangementService = new BoxMangementService();
    }
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $args['id'] ?? null;
        $userId = $_SESSION['user']['id'] ?? "";
        $box = $this->boxMangementService->getBoxWithPrestations($boxId, $userId);

        $tab = [
            'box' => [
                'id' => $box['id'],
                'libelle' => $box['libelle'],
                'description' => $box['description'],
                'message_kdo' => $box['message_kdo'] ?? '',
                'statut' => $box['statut'],
                'prestations' => []
            ]
        ];

        foreach ($box['prestations'] as $prestation) {
            $tab['box']['prestations'][] = [
                'libelle' => $prestation['libelle'],
                'description' => $prestation['description'],
                'contenu' => [
                    "box_id" => $box['id'],
                    "prestation_id" => $prestation['id'],
                    "quantite" => $prestation['pivot']['quantite']
                ]
            ];
        }

        $data = [
            "type" => "ressource",
            'box' => $tab['box']
        ];

        $response->getBody()->write(json_encode($data));
        return
            $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
