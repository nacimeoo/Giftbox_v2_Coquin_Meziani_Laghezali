<?php

declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetBoxAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        return $response;
    }
}