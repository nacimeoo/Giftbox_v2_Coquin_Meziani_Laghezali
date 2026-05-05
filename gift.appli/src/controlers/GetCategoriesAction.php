<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;

class GetCategoriesAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        $categories = Categorie::all();

        $html ="<h1>Catégories</h1>";
        foreach ($categories as $c) {
            $html .= "<p><a href=\"/categorie/{$c->id}\">{$c->libelle}</a></p>";
        }
        $rs->getBody()->write($html);
        return $rs;
    }
}