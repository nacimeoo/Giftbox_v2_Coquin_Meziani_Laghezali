<?php

declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class GetPrestationAction extends AbstractAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $params = $rq->getQueryParams();
        if (!isset($params['id'])) {
            throw new HttpBadRequestException($rq, "id manquant");
        }
        $id = $params['id'];
        $prestation = Prestation::find($id);
        if (is_null($prestation)) {
            throw new HttpNotFoundException($rq, "Prestation n°{$id} introuvable");
        }

        $html = "<h1>{$prestation->libelle}</h1>";
        $html .= "<p>Description : {$prestation->description}</p>";
        $html .= "<p>Tarif : {$prestation->tarif} €</p>";

        $rs->getBody()->write($html);
        return $rs;
    }
}
