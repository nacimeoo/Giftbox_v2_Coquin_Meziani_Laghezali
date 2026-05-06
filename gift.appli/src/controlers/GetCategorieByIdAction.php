<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class GetCategorieByIdAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        if(!isset($args['id'])) {
            throw new HttpBadRequestException($rq,"faut un id");
        }
        $id = (int)$args['id'];
        $categorie = Categorie::find($id);
        if(is_null($categorie)) {
            throw new HttpNotFoundException($rq,"introuvable");
        }
        

        $html = "<h1>Catégorie n°{$categorie->id}</h1>";
        $html .= "<p>Libellé : {$categorie->libelle}</p>";
        $html .= "<p>Description : {$categorie->description}</p>";

        $rs->getBody()->write($html);
        return $rs;
    }
}