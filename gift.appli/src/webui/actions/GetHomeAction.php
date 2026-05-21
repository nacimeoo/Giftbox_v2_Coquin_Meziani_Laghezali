<?php
declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\domain\entities\Categorie;
use Illuminate\Database\QueryException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class GetHomeAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {

        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'home.twig');
        
    }
}