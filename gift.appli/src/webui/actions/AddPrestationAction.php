<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\usecases\BoxMangementService;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;
use gift\appli\webui\providers\AuthProvider;
use gift\appli\application_core\application\authorization\AuthorizationInterface;
use gift\appli\application_core\application\authorization\AuthorizationService;
use Slim\Exception\HttpForbiddenException;
use Ramsey\Uuid\Uuid;


class AddPrestationAction
{

    private BoxMangementService $boxManagementService;
    private AuthProvider $authProvider;
    private AuthorizationService $authService;

    public function __construct()
    {
        $this->boxManagementService = new BoxMangementService();
        $this->authProvider = new AuthProvider(); 
        $this->authService = new AuthorizationService();  
    }

    public function __invoke(Request $request, Response $response, array $args): Response    
    {

        $prestaId = $args['id'];

        $boxId = $_SESSION['box_Actuel'] ?? null;

        if (!$boxId) {
            throw new HttpInternalServerErrorException($request, "Aucune box sélectionnée pour ajouter la prestation.");
        }

        $userId = $this->authProvider->getSignedInUser()['id'] ?? null;
        $role = $this->authProvider->getSignedInUser()['role'] ?? null;
        $BoxUuid = Uuid::fromString($boxId);
        

        if (!$this->authService->isGranted(['id' => $userId, 'role' => $role], AuthorizationInterface::OPERATION_ADD_PRESTA, $BoxUuid)) {
            throw new HttpForbiddenException($request, "Vous n'avez pas les permissions nécessaires pour ajouter une prestation à cette box.");
        }

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