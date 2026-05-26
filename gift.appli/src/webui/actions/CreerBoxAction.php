<?php

namespace gift\appli\webui\actions;

class CreerBoxAction
{


    private BoxMangementService $boxManagementService;

    public function __construct(BoxMangementService $boxManagementService)
    {
        $this->boxManagementService = $boxManagementService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response    
    {

        $data = $request->getParsedBody() ?? [];

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

            $routeContexte = RouteContext::fromRequest($request);
            $routeParser = $routeContexte->getRouteParser();
            $url = $routeParser->urlFor('box', ['id' => $boxId]);
        } catch (\Exception $e) {
            throw new HttpInternalServerErrorException($request, "Erreur lors de la création de la box : " . $e->getMessage());
        }



        
            



       
    }
}