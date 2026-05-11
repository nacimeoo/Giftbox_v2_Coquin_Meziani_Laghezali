<?php

declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;
use Slim\Views\Twig;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class GetCategorieByIdAction extends AbstractAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        if (!isset($args['id'])) {
            throw new HttpBadRequestException($rq, "faut un id");
        }
        $id = (int)$args['id'];

        try {
            $categorie = Categorie::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpNotFoundException($rq, "introuvable");
        } catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "erreur de bdd");
        }

        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'categorie.twig', $categorie->toArray());
    }
}
