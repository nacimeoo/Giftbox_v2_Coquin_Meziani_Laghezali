<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use gift\appli\application_core\application\usecases\BoxService;
use Exception;

class GenererUrlAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $args['id'];
        
        $userId = '9c025060-305b-4e47-aa94-313cdc1381f8'; 

        $service = new BoxService();
        
        try {
            $token = $service->generateToken($boxId, $userId);
            
            $url = "/box/access/" . $token; 
            $response->getBody()->write("L'URL d'accès de votre box : <a href='$url'>$url</a>");
            
            return $response;
            
        } catch (Exception $e) {
            $response->getBody()->write("Erreur : " . $e->getMessage());
            return $response->withStatus(400);
        }
    }
}