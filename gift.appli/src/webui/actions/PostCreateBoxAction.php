<?php

declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\providers\CsrfTokenProvider;
use gift\appli\application_core\application\usecases\BoxMangementService;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class PostCreateBoxAction extends AbstractAction
{
    private $boxManagementService;

    public function __construct()
    {
        $this->boxManagementService = new BoxMangementService();
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $data = $rq->getParsedBody();
        $csrfToken = $data['csrf_token'] ?? '';
        try {
            (new CsrfTokenProvider())->check($csrfToken);
        } catch (\Exception $e) {
            throw new HttpForbiddenException($rq, "Erreur de sécurité CSRF : " . $e->getMessage());
        }
        $libelle = filter_var($data['libelle'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_var($data['description'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $kdo = isset($data['kdo']) ? (int)$data['kdo'] : 0;
        $messageKdo = filter_var($data['message_kdo'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($libelle) || empty($description)) {
            throw new HttpBadRequestException($rq, "Le libellé et la description sont obligatoires.");
        }
        $boxData = [
            'libelle' => $libelle,
            'description' => $description,
            'kdo' => $kdo,
            'message_kdo' => $messageKdo
        ];
        $userId = "user_demo"; 
        $nouvelleBoxId = $this->boxManagementService->createBox($boxData, $userId);
        $_SESSION['current_box_id'] = $nouvelleBoxId;
        return $rs->withHeader('Location', '/box?box_id=' . $nouvelleBoxId . '&user_id=' . $userId)->withStatus(302);
    }
}