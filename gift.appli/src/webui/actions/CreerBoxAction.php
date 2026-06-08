<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\usecases\BoxMangementService;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpInternalServerErrorException;
use gift\appli\webui\providers\CsrfTokenProvider;
use Slim\Exception\HttpForbiddenException;
use gift\appli\webui\providers\AuthProvider;
use gift\appli\application_core\application\usecases\AuthorizationInterface;
use gift\appli\application_core\application\usecases\AuthorizationService;


class CreerBoxAction
{


    private BoxMangementService $boxManagementService;
    private AuthProvider $authProvider;
    private AuthorizationService $authService;

    public function __construct()
    {
        $this->boxManagementService = new BoxMangementService();
        $this->authProvider = new AuthProvider();
        $this->authService = new AuthorizationService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response    
    {

        $data = $request->getParsedBody() ?? [];

                $csrfToken = $data['csrf_token'] ?? '';
        try {
            (new CsrfTokenProvider())->check($csrfToken);
        } catch (\Exception $e) {
            throw new HttpForbiddenException($request, "Erreur de sécurité CSRF : " . $e->getMessage());
        }

        $user = $this->authProvider->getSignedInUser();
        if (!$user) {
            throw new HttpForbiddenException($request, "connecte toi stv cree ta box");
        }
        $userId = $this->authProvider->getSignedInUser()['id'] ?? null;
        $role = $this->authProvider->getSignedInUser()['role'] ?? null;
        

        if (!$this->authService->isGranted(['id' => $userId, 'role' => $role], AuthorizationInterface::OPERATION_CREER_BOX, null)) {
            throw new HttpForbiddenException($request, "Vous n'avez pas les permissions nécessaires pour créer cette box.");
        }

        $userId = $user['id'];
        $libelle = filter_var($data['libelle'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_var($data['description'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $kdo = isset($data['kdo']) ? 1 : 0;
        $message_kdo = filter_var($data['message_kdo'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);


        try {
            $boxId = $this->boxManagementService->createBox([
                'libelle' => $libelle,
                'description' => $description,
                'kdo' => $kdo,
                'message_kdo' => $message_kdo
            ], $userId);

            $_SESSION['box_Actuel'] = $boxId;

            $routeContexte = RouteContext::fromRequest($request);
            $routeParser = $routeContexte->getRouteParser();
            $url = $routeParser->urlFor('box', ['id' => $boxId]);

            return $response->withHeader('Location', $url)->withStatus(302);
        } catch (\Exception $e) {
            throw new HttpInternalServerErrorException($request, "Erreur lors de la création de la box : " . $e->getMessage());
        }



        
            



       
    }
}