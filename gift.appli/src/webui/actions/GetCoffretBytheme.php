<?php
declare(strict_types=1);
namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\domain\entities\Categorie;
use gift\appli\application_core\domain\entities\CoffretType;
use gift\appli\application_core\domain\entities\Theme;
use Illuminate\Database\QueryException;
use gift\appli\application_core\domain\Exception\CatalogueException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;
use Slim\Exception\HttpNotFoundException;

class GetCoffretBytheme extends AbstractAction {

    private $catalogueService;
    
    public function __construct($catalogueService) {
        $this->catalogueService = new \gift\appli\application_core\application\usecases\CatalogueService();
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response {

        try{
            $coffret = $this->catalogueService->getThemesCoffrets();
        } catch (CatalogueException $e) {
            if ($e->getCode() === 404) {
                throw new HttpNotFoundException($rq, $e->getMessage());
            }
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreur de base de données.");
        }


        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'coffret.twig', ['theme' => $coffret['themes'],'coffrets' => $coffret['coffrets']]);
        
    }
}