<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetCategoriesAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Liste des catégories</title>
        </head>
        <body>
            <h1>Catégories</h1>
            <ul>
                <li><a href="/categorie/1">1 - Soins</a></li>
                <li><a href="/categorie/2">2 - Massages</a></li>
                <li><a href="/categorie/3">3 - Coiffure</a></li>
            </ul>
        </body>
        </html>
        HTML;

        $rs->getBody()->write($html);
        return $rs;
    }
}