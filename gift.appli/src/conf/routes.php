<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (Slim\App $app): Slim\App {
    $app->get('/categories', function (Request $request, Response $response, array $args): Response {
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

        $response->getBody()->write($html);
        return $response;
    });

    $app->get('/categorie/{id}', function (Request $request, Response $response, array $args): Response {
        $id = isset($args['id']) ? (int) $args['id'] : 0;
        $label = null;
        if ($id === 1) $label = 'Soins du visage';
        if ($id === 2) $label = 'Massages';
        if ($id === 3) $label = 'Coiffure';

        // if ($label === null) {
        //     $response->getBody()->write('<p>Catégorie inconnue.</p>');
        //     return $response->withStatus(404);
        // }

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

        $response->getBody()->write($html);
        return $response;
    });

    $app->get('/prestation', function (Request $request, Response $response, array $args): Response {
        $params = $request->getQueryParams();
        if (!isset($params['id']) || $params['id'] === '') {
            $response->getBody()->write('<p>Paramètre manquant : id requis.</p>');
            return $response->withStatus(400);
        }
        $id = (int) $params['id'];
        $prestations = [10 => ['title' => 'Massage détente', 'price' => '50€'], 11 => ['title' => 'Soin visage', 'price' => '40€']];
        if (!isset($prestations[$id])) {
            $response->getBody()->write('<p>Prestation introuvable.</p>');
            return $response->withStatus(404);
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

        $response->getBody()->write($html);
        return $response;
    });

    return $app;
};

