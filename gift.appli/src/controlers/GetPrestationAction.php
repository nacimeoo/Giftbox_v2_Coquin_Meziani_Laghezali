<?php

declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class GetPrestationAction extends AbstractAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $params = $rq->getQueryParams();

        $id = $params['id'] ?? null;

        if (is_null($id)) {
            throw new HttpBadRequestException($rq, "id manquant");
        }
        try {
            $prestation = Prestation::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            throw new HttpNotFoundException($rq, "Prestation non trouvée");
        }catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreurbdd");
        }
        

        $html = "<h1>{$prestation->libelle}</h1>";
        $html .= "<p>Description : {$prestation->description}</p>";
        $html .= "<p>Tarif : {$prestation->tarif} €</p>";

        $rs->getBody()->write($html);
        return $rs;
    }
}
