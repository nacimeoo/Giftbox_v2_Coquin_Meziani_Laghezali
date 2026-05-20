<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;
use Illuminate\Database\QueryException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class GetCategoriesAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        try {
            $categories = Categorie::all();
        } catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreur bdd");
        }

        $routescontexte=RouteContext::fromRequest($rq);
        $routeParser=$routescontexte->getRouteParser();
        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'categories.twig', ['categories' => $categories->toArray()]);
        
    }
}