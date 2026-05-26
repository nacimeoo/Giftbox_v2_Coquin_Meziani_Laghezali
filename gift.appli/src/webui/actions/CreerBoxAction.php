<?php

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\application\usecases\BoxMangementService;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpInternalServerErrorException;
use gift\appli\application_core\application\providers\CsrfTokenProvider;
use Slim\Exception\HttpForbiddenException;


class CreerBoxAction
{


    private BoxMangementService $boxManagementService;

    public function __construct()
    {
        $this->boxManagementService = new BoxMangementService();
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


        $libelle = filter_var($data['libelle'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_var($data['description'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $kdo = isset($data['kdo']) ? 1 : 0;
        $message_kdo = filter_var($data['message_kdo'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        $userId = '9c025060-305b-4e47-aa94-313cdc1381f8';

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