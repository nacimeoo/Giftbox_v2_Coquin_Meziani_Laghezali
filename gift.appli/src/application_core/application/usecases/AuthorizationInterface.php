<?php

namespace gift\appli\application_core\application\usecases;

use Ramsey\Uuid\Uuid;

interface AuthorizationInterface
{
    public const OPERATION_CREER_BOX = 'creer_box';
    public const OPERATION_VIEW_BOX = 'view_box';
    public const OPERATION_VALIDER_BOX = 'valider_box';
    public const OPERATION_ADD_PRESTA = 'add_presta';
    public const OPERATION_GENERER_URL = 'generer_url';

    public function isGranted(array $user_profile, string $operation, ?Uuid $ressource_id = null): bool;
}