<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;

class GetCategorieByIdAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        $id = (int)$args['id'];
        $categorie = Categorie::find($id);   

        $html = "<h1>Catégorie n°{$categorie->id}</h1>";
        $html .= "<p>Libellé : {$categorie->libelle}</p>";
        $html .= "<p>Description : {$categorie->description}</p>";

        $rs->getBody()->write($html);
        return $rs;
    }
}