<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpBadRequestException;

class GetCurrentBoxAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $_SESSION['box_Actuel'] ?? null;

        if (!$boxId) {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('box_post');
            return $response->withHeader('Location', $url)->withStatus(302);
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('box', ['id' => $boxId]);
        
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}