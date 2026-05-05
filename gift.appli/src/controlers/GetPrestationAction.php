<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetPrestationAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        $params = $rq->getQueryParams();
        
        if (!isset($params['id']) || $params['id'] === '') {
            $rs->getBody()->write('<p>Paramètre manquant : id requis.</p>');
            return $rs->withStatus(400);
        }
        
        $id = (int) $params['id'];
        $prestations = [10 => ['title' => 'Massage détente', 'price' => '50€'], 11 => ['title' => 'Soin visage', 'price' => '40€']];
        
        if (!isset($prestations[$id])) {
            $rs->getBody()->write('<p>Prestation introuvable.</p>');
            return $rs->withStatus(404);
        }
        
        $p = $prestations[$id];
        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Prestation {$id}</title>
        </head>
        <body>
            <h1>{$p['title']}</h1>
            <p>Référence : {$id}</p>
            <p>Prix : {$p['price']}</p>
        </body>
        </html>
        HTML;

        $rs->getBody()->write($html);
        return $rs;
    }
}