<?php

declare(strict_types=1);

namespace gift\appli\controlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\models\Categorie;
use gift\appli\models\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Slim\Views\Twig;
use gift\appli\models\CoffretType;

class GetCoffretDetaille extends AbstractAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $params = $rq->getQueryParams();

        $id = $params['id'] ?? null;

        if (is_null($id)) {
            throw new HttpBadRequestException($rq, "id manquant");
        }
        try {
            $coffret = CoffretType::with('prestations')->findOrFail($id);
        }
        catch (ModelNotFoundException $e) { 
            throw new HttpNotFoundException($rq, "Coffret non trouvé");
        }catch (QueryException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreurbdd");
        }
        

        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'coffretdetaille.twig', ['coffret' => $coffret->toArray()]);
    }
}