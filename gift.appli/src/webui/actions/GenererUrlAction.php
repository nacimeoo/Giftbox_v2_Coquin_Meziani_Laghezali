<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use gift\appli\application_core\application\usecases\BoxService;
use gift\appli\webui\providers\CsrfTokenProvider;
use Slim\Views\Twig;
use Slim\Routing\RouteContext; 
use Slim\Exception\HttpForbiddenException;
use Exception;

class GenererUrlAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $args['id'];   
        $data = $request->getParsedBody();
        $csrfToken = $data['csrf_token'] ?? '';
        try {
            (new CsrfTokenProvider())->check($csrfToken);
        } catch (Exception $e) {
            throw new HttpForbiddenException($request, "Erreur de sécurité : Jeton CSRF invalide.");
        }

        $userId = $_SESSION['user']['id'] ?? null;

        $service = new BoxService();

        try {
            $token = $service->generateToken($boxId, $userId);

            $routeContext = RouteContext::fromRequest($request);
            $routeParser = $routeContext->getRouteParser();


            $url1 = $routeParser->urlFor('box_access', ['token' => $token]);
            $url2=  $request->getUri();
            $url3= $url2->getScheme() . '://' . $url2->getHost();;
            $url4= $url3 .$url1;

            $view = Twig::fromRequest($request);
            return $view->render($response, 'url.twig', ['url' => $url4]);
        } catch (Exception $e) {
            $response->getBody()->write("Erreur : " . $e->getMessage());
            return $response->withStatus(400);
        }
    }
}
