<?php

declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\providers\CsrfTokenProvider;
use Slim\Views\Twig;

class GetCreateBoxAction extends AbstractAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $token = (new CsrfTokenProvider())->generate();
        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'box_cree.twig', [
            'csrf' => $token
        ]);
    }
}