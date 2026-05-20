<?php

declare(strict_types=1);

namespace WebUI\Actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\core\domain\entities\Categorie;
use Slim\Views\Twig;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use ApplicationCore\Domain\Exceptions\CatalogueException;


class GetCategorieByIdAction extends AbstractAction
{

    private $catalogueService;
    
    public function __construct($catalogueService) {
        $this->catalogueService = $catalogueService;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        if (!isset($args['id'])) {
            throw new HttpBadRequestException($rq, "faut un id");
        }
        $id = (int)$args['id'];

        try {
            $categorie = $this->catalogueService->getCategorieById($id);
        } catch (CatalogueException $e) {
            if ($e->getCode() === 404) {
                throw new HttpNotFoundException($rq, "introuvable");
            }
            throw new HttpInternalServerErrorException($rq, "erreur de bdd");
        }
        

        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'categorie.twig', $categorie->toArray());
    }
}
