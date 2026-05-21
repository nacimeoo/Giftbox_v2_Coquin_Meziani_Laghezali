<?php
declare(strict_types=1);
namespace gift\appli\src\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\core\domain\entities\Categorie;
use gift\core\domain\entities\CoffretType;
use gift\core\domain\entities\Theme;

use gift\appli\src\application_core\domain\Exception\CatalogueException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class GetCoffretBytheme extends AbstractAction {

    private $catalogueService;
    
    public function __construct($catalogueService) {
        $this->catalogueService = $catalogueService;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response {

        try{
            $coffret = $this->catalogueService->getThemeCoffret();
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