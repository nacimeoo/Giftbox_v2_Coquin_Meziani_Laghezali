<?php

declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\domain\Exception\BoxNotFoundException;
use gift\appli\application_core\domain\Exception\UnauthorizedAccessException;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Views\Twig;
use Exception;

class GetBoxWithPrestationsAction extends AbstractAction
{
    private $boxMangementService;

    public function __construct()
    {
        $this->boxMangementService = new \gift\appli\application_core\application\usecases\BoxMangementService();
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $boxId = $args['id'] ?? null;

        if (!$boxId) {
            throw new HttpBadRequestException($rq, "L'identifiant de la box est manquant.");
        }

        $userId = '9c025060-305b-4e47-aa94-313cdc1381f8';


        try {
            $box = $this->boxMangementService->getBoxWithPrestations($boxId, $userId);
        } catch (BoxNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (UnauthorizedAccessException $e) {
            throw new HttpForbiddenException($rq, $e->getMessage());
        } catch (Exception $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
        $view = Twig::fromRequest($rq);
        return $view->render($rs, 'box_access.twig', ['box' => $box]);
    }
}
