<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;
use Illuminate\Database\QueryException;
use Slim\Exception\HttpInternalServerErrorException;

class GetCategoriesAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        try {
            $categories = Categorie::all();
        } catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreur bdd");
        }
        
        $html ="<h1>Catégories</h1>";
        foreach ($categories as $c) {
            $html .= "<p><a href=\"/categorie/{$c->id}\">{$c->libelle}</a></p>";
        }
        $rs->getBody()->write($html);
        return $rs;
    }
}