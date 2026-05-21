<?php

declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\domain\entities\Categorie;
use gift\appli\application_core\domain\Exception\CatalogueException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;
use Illuminate\Database\QueryException;

class GetCategoriesAction extends AbstractAction
{

    private $catalogueService;

    public function __construct($catalogueService)
    {
        $this->catalogueService = new \gift\appli\application_core\application\usecases\CatalogueService();
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        try {
            $categories = $this->catalogueService->getCategories();
        } catch (CatalogueException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreur bdd");
        }

        $routescontexte = RouteContext::fromRequest($rq);
        $routeParser = $routescontexte->getRouteParser();
        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'categories.twig', ['categories' => $categories]);
    }
}
