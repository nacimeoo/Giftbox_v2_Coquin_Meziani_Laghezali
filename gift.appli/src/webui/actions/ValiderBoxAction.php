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

class ValiderBoxAction
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
        $boxId = $args['id'];
        $userId = $this->authProvider->getSignedInUser()['id'] ?? null;

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