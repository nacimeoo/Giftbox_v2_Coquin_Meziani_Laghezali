<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetCategorieByIdAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        $id = isset($args['id']) ? (int) $args['id'] : 0;
        $label = null;
        
        if ($id === 1) $label = 'Soins';
        if ($id === 2) $label = 'Massages';
        if ($id === 3) $label = 'Coiffure';

        if ($label === null) {
            $rs->getBody()->write('<p>Catégorie inconnue.</p>');
            return $rs->withStatus(404);
        }

        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Catégorie {$id}</title>
        </head>
        <body>
            <h1>Catégorie n°{$id}</h1>
            <p>Libellé : {$label}</p>
        </body>
        </html>
        HTML;

        $rs->getBody()->write($html);
        return $rs;
    }
}