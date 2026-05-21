<?php

declare(strict_types=1);
namespace gift\appli\webui\actions;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\domain\entities\Categorie;
use gift\appli\application_core\domain\entities\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use gift\appli\application_core\domain\Exception\CatalogueException;
use Slim\Views\Twig;
use Illuminate\Database\QueryException;
use gift\appli\application_core\domain\entities\CoffretType;

class GetCoffretDetaille extends AbstractAction
{

    private $catalogueService;
    
    public function __construct($catalogueService) {
        $this->catalogueService = new \gift\appli\application_core\application\usecases\CatalogueService();
    }
    
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $params = $rq->getQueryParams();

        $id = $params['id'] ?? null;

        if (is_null($id)) {
            throw new HttpBadRequestException($rq, "id manquant");
        }
        try {
            $coffret = $this->catalogueService->getCoffretById((int)$id);
        }
        catch (CatalogueException $e) { 
            if ($e->getCode() === 404) {
                throw new HttpNotFoundException($rq, $e->getMessage());
            }
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
        catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreur de base de données.");
        }
        

        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'coffretdetaille.twig', ['coffret' => $coffret]);
    }
}