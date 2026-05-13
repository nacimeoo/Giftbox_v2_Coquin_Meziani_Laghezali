<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;
use gift\appli\models\CoffretType;
use gift\appli\models\Theme;
use Illuminate\Database\QueryException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class GetCoffretBytheme extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {

        try{
            $coffret = CoffretType::all('libelle','description');
            $theme = Theme::all('libelle');
        } catch (QueryException $e) {
        throw new HttpInternalServerErrorException($rq, "Erreur BDD");
    }


        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'coffret.twig', ['theme' => $theme->toArray(),'coffrets' => $coffret->toArray()]);
        
    }
}