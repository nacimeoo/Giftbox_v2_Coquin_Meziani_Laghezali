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
use gift\appli\application_core\application\authorization\AuthorizationInterface;
use gift\appli\application_core\application\authorization\AuthorizationService;
use gift\appli\webui\providers\AuthProvider;
use Ramsey\Uuid\Uuid;

class GetBoxWithPrestationsAction extends AbstractAction
{
    private $boxMangementService;
    private AuthorizationService $authService;
    private AuthProvider $authProvider;

    public function __construct()
    {
        $this->boxMangementService = new \gift\appli\application_core\application\usecases\BoxMangementService();
        $this->authService = new AuthorizationService();
        $this->authProvider = new AuthProvider();
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $boxId = $_SESSION['box_Actuel'] ?? null;

        if (!$boxId) {
            throw new HttpBadRequestException($rq, "L'identifiant de la box est manquant.");
        }

        $userId = $_SESSION['user']['id'] ?? null;

        $userId = $this->authProvider->getSignedInUser()['id'] ?? null;
        $role = $this->authProvider->getSignedInUser()['role'] ?? null;

        $boxUuid = Uuid::fromString($boxId);

        if (!$this->authService->isGranted(['id' => $userId, 'role' => $role], AuthorizationInterface::OPERATION_VIEW_BOX, $boxUuid)) {
            throw new HttpForbiddenException($rq, "Vous n'avez pas les permissions nécessaires pour visualiser cette box.");
        }

        if (!$userId) {
            throw new HttpBadRequestException($rq, "L'identifiant de l'utilisateur est manquant.");
        }

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
