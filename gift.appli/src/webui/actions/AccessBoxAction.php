<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use gift\appli\application_core\application\usecases\BoxService;
use Slim\Views\Twig;
use Exception;

class AccessBoxAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $token = $args['token'];
        $service = new BoxService();
        
        try {
            $box = $service->getBoxByToken($token);
            $view = Twig::fromRequest($request);
            
            return $view->render($response, 'box_access.twig', ['box' => $box]);
            
        } catch (Exception $e) {
            $response->getBody()->write("Erreur : " . $e->getMessage());
            return $response->withStatus(404);
        }
    }
}