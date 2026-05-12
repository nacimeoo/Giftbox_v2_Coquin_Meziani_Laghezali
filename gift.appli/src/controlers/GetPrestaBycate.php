<?php

declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;
use gift\appli\models\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Slim\Views\Twig;

class GetPrestaBycate extends AbstractAction{
    public function __invoke(Request $rq, Response $rs, array $args): Response
{
    $params = $rq->getQueryParams();
    $id = $params['cat_id'] ?? null;

    if (is_null($id)) {
        throw new HttpBadRequestException($rq, "id manquant");
    }

    try {
        $prestations = Prestation::where('cat_id', '=', $id)->get();
        $categorie = Categorie::findOrFail($id);
    } catch (ModelNotFoundException $e) {
        throw new HttpNotFoundException($rq, "Prestation non trouvée");
    } catch (QueryException $e) {
        throw new HttpInternalServerErrorException($rq, "Erreur BDD");
    }

    $view = Twig::fromRequest($rq);
    return $view->render($rs, 'presta_liste.twig', ['prestations' => $prestations->toArray(),'categorie'   => $categorie->toArray()]);

}


}