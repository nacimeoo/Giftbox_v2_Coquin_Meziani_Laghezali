<?php

declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\domain\entities\Categorie;
use gift\appli\application_core\domain\entities\Prestation;
use gift\appli\application_core\domain\Exception\BoxNotFoundException;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use gift\appli\application_core\domain\Exception\CatalogueException;
use Slim\Views\Twig;

class GetBoxWithPrestationsAction extends AbstractAction
{
    private $boxMangementService;

    public function __construct()
    {
        $this->boxMangementService = new \gift\appli\application_core\application\usecases\BoxMangementService();
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $params = $rq->getQueryParams();
        $box=$params['box_id'] ?? null;
        $user=$params['user_id'] ?? null;

        if (is_null($box) || is_null($user)) {
            throw new HttpBadRequestException($rq, " tu dois meetre un id");
    }
    try{
        $box=$this->boxMangementService->getBoxWithPrestations($box,(string)$user);
    }catch (BoxNotFoundException $e) {
        if ($e->getCode() === 404) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }
        throw new HttpInternalServerErrorException($rq, $e->getMessage());
    }
    $view = Twig::fromRequest($rq);
    return $view->render($rs, 'box_acces.twig', ['box' => $box]);
}
}