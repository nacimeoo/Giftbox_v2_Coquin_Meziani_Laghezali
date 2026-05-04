<?php
<<<<<<< HEAD
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (Slim\App $app) {

    $app->get('/categories', function (Request $rq, Response $rs, array $args): Response {
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
                <li><a href="/categorie/1">1 - Soins du visage</a></li>
                <li><a href="/categorie/2">2 - Massages</a></li>
                <li><a href="/categorie/3">3 - Coiffure</a></li>
            </ul>
        </body>
        </html>
        HTML;

        $rs->getBody()->write($html);
        return $rs;
    });

    
    
};
=======

declare(strict_types=1);

require_once __DIR__ . '/../src/vendor/autoload.php';
require_once __DIR__ . '/../../public/index.php';
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


>>>>>>> 88254e6b45b6e3b62beb6133fdb65aadd802cce5
