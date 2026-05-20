<?php

declare(strict_types=1);

namespace WebUI\Actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\core\domain\entities\Categorie;
use gift\core\domain\entities\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;

use ApplicationCore\Domain\Exceptions\CatalogueException;
use Slim\Views\Twig;

class GetPrestationAction extends AbstractAction
{

    private $catalogueService;
    
    public function __construct($catalogueService) {
        $this->catalogueService = $catalogueService;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $params = $rq->getQueryParams();

        $id = $params['id'] ?? null;

        if (is_null($id)) {
            throw new HttpBadRequestException($rq, "id manquant");
        }
        try {

            $prestation = $this->catalogueService->getPrestationById((string)$id);    

        }catch (CatalogueException $e) {
            if ($e->getCode() === 404) {
                throw new HttpNotFoundException($rq, $e->getMessage());
            }
        }catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreurbdd");
        }
        

        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'prestation.twig', ['prestation' => $prestation->toArray()]);
    }
}