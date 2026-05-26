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



    }
}