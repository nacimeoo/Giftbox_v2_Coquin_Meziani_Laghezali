<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\usecases\BoxMangementService;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use gift\appli\application_core\domain\Exception\NotEnoughPrestationsException;
use gift\appli\webui\providers\AuthProvider;
use gift\appli\application_core\application\usecases\AuthorizationInterface;
use gift\appli\application_core\application\usecases\AuthorizationService;
use Slim\Exception\HttpForbiddenException;
use Ramsey\Uuid\Uuid;

class ValiderBoxAction
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
        $boxId = $args['id'];
        $userId = $this->authProvider->getSignedInUser()['id'] ?? null;
        $role = $this->authProvider->getSignedInUser()['role'] ?? null;

        $boxUuid = Uuid::fromString($boxId);

        if (!$this->authService->isGranted(['id' => $userId, 'role' => $role], AuthorizationInterface::OPERATION_VALIDER_BOX, $boxUuid)) {
            throw new HttpForbiddenException($request, "Vous n'avez pas les permissions nécessaires pour valider cette box.");
        }
        try {
            $this->boxManagementService->validerBox($boxId, $userId);

            $routeContexte = RouteContext::fromRequest($request);
            $routeParser = $routeContexte->getRouteParser();
            $url = $routeParser->urlFor('box', ['id' => $boxId]);

            return $response->withHeader('Location', $url)->withStatus(302);
            
        } catch (NotEnoughPrestationsException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpInternalServerErrorException($request, "Erreur lors de la validation : " . $e->getMessage());
        }
    }
}