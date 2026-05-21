<?php

declare(strict_types=1);

namespace gift\appli\src\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\core\domain\entities\Categorie;
use gift\core\domain\entities\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use gift\appli\src\application_core\domain\Exception\CatalogueException;
use Slim\Views\Twig;

class GetPrestaBycate extends AbstractAction{

    private $catalogueService;
    
    public function __construct($catalogueService) {
        $this->catalogueService = $catalogueService;
    }
    
    public function __invoke(Request $rq, Response $rs, array $args): Response
{
    $params = $rq->getQueryParams();
    $id = $params['cat_id'] ?? null;

    if (is_null($id)) {
        throw new HttpBadRequestException($rq, "id manquant");
    }

    try {
        $categorie = $this->catalogueService->getCategorieById((int)$id);
        $prestations = $this->catalogueService->getPrestationsbyCategorie((int)$id);
    } catch (CatalogueException $e) {
        if ($e->getCode() === 404) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }
        throw new HttpInternalServerErrorException($rq, $e->getMessage());
    }

    $view = Twig::fromRequest($rq);
    return $view->render($rs, 'presta_liste.twig', ['prestations' => $prestations, 'categorie' => $categorie]);
    }


}