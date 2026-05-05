<?php
declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Prestation;

class GetPrestationAction extends AbstractAction {
    public function __invoke(Request $rq, Response $rs, array $args): Response {
        $params = $rq->getQueryParams();
        
        if (!isset($params['id']) || $params['id'] === '') {
            $rs->getBody()->write('<p>Paramètre manquant : id requis.</p>');
            return $rs->withStatus(400);
        }
        
        $id = $params['id'];
        $prestation = Prestation::find($id);
        
        if (!$prestation) {
            $rs->getBody()->write('<p>Prestation introuvable.</p>');
            return $rs->withStatus(404);
        }
        
        $html = "<h1>{$prestation->libelle}</h1>";
        $html .= "<p>Description : {$prestation->description}</p>";
        $html .= "<p>Tarif : {$prestation->tarif} €</p>";

        $rs->getBody()->write($html);
        return $rs;
    }
}