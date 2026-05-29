<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\usecases\BoxMangementService;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;
use gift\appli\webui\providers\AuthProvider;


class AddPrestationAction
{

    private BoxMangementService $boxManagementService;
    private AuthProvider $authProvider;
    public function __construct()
    {
        $this->boxManagementService = new BoxMangementService();
        $this->authProvider = new AuthProvider();   
    }

    public function __invoke(Request $request, Response $response, array $args): Response    
    {

        $prestaId = $args['id'];

        $boxId = $_SESSION['box_Actuel'] ?? null;

        if (!$boxId) {
            throw new HttpInternalServerErrorException($request, "Aucune box sélectionnée pour ajouter la prestation.");
        }

        $userId = $this->authProvider->getSignedInUser()['id'] ?? null;

        try {
            $this->boxManagementService->addPrestationToBox($boxId, $prestaId, $userId);

            $routeContexte = RouteContext::fromRequest($request);
            $routeParser = $routeContexte->getRouteParser();
            $url = $routeParser->urlFor('box', ['id' => $boxId]);

            return $response->withHeader('Location', $url)->withStatus(302);
            
        } catch (\Exception $e) {
            throw new HttpInternalServerErrorException($request, "Erreur lors de l'ajout de la prestation : " . $e->getMessage());
        }

    }
}