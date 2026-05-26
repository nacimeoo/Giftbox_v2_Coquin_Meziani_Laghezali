<?php
declare(strict_types=1);

use gift\appli\webui\actions\GetCategoriesAction;
use gift\appli\webui\actions\GetCategorieByIdAction;
use gift\appli\webui\actions\GetPrestationAction;
use gift\appli\webui\actions\GetPrestaBycate;
use gift\appli\webui\actions\GetHomeAction;
use gift\appli\webui\actions\GetCoffretBytheme;
use gift\appli\webui\actions\GetCoffretDetaille;
use gift\appli\webui\actions\GenererUrlAction;
use gift\appli\webui\actions\AccessBoxAction;
use gift\appli\webui\actions\GetBoxWithPrestationsAction;
use gift\appli\webui\actions\GetCreateBoxAction;
use gift\appli\webui\actions\CreerBoxAction;


return function (Slim\App $app): Slim\App {
    $app->get('/categories', GetCategoriesAction::class)->setName('categories');
    $app->get('/categorie[/{id}]', GetCategorieByIdAction::class)->setName('categorie');
    $app->get('/prestation', GetPrestationAction::class)->setName('prestation');
    $app->get('/presta2', GetPrestaBycate::class)->setName('presta2');
    $app->get('/home', GetHomeAction::class)->setName('home');
    $app->get('/coffret', GetCoffretBytheme::class)->setName('coffret');
    $app->get('/coffretDetaille', GetCoffretDetaille::class)->setName('coffretDetaille');
    $app->post('/box/{id}/url', GenererUrlAction::class)->setName('generate_box_url');
    $app->get('/box/access/{token}', AccessBoxAction::class)->setName('box_access');
    $app->get('/box/create', GetCreateBoxAction::class)->setName('box_get');
    $app->post('/box/create', CreerBoxAction::class)->setName('box_post');
    $app->get('/box/{id}', GetBoxWithPrestationsAction::class)->setName('box');

    return $app;
};

    