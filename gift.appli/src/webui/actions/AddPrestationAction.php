<?php

namespace gift\appli\webui\actions;

class AddPrestationAction
{

    private BoxMangementService $boxManagementService;

    public function __construct(BoxMangementService $boxManagementService)
    {
        $this->boxManagementService = $boxManagementService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response    
    {

        $prestaId = $args['presta_id'];

        $boxId = $_SESSION['box_Actuel'] ?? null;

        if (!$boxId) {
            throw new HttpInternalServerErrorException($request, "Aucune box sélectionnée pour ajouter la prestation.");
        }

        $userId = '9c025060-305b-4e47-aa94-313cdc1381f8';

        try {
            $this->boxManagementService->addPrestationToBox($boxId, $prestaId, $userId);

            $routeContexte = RouteContext::fromRequest($request);
            $routeParser = $routeContexte->getRouteParser();
            $url = $routeParser->urlFor('box', ['id' => $boxId]);

            return $response->withHeader('Location', $url)->withStatus(302);
            
        } catch (\Exception $e) {
            throw new HttpInternalServerErrorException($request, "Erreur lors de l'ajout de la prestation : " . $e->getMessage());
        }



    }
}