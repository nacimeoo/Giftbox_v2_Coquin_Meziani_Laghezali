<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\usecases\BoxMangementService;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use gift\appli\application_core\domain\Exception\NotEnoughPrestationsException;

class ValidateBoxAction
{
    private BoxMangementService $boxManagementService;

    public function __construct()
    {
        $this->boxManagementService = new BoxMangementService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response    
    {
        $boxId = $args['id'];
        $userId = '9c025060-305b-4e47-aa94-313cdc1381f8';

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