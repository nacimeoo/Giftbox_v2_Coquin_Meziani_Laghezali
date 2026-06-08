<?php

namespace gift\appli\application_core\application\authorization;

use Ramsey\Uuid\Uuid;

class AuthorizationService implements AuthorizationInterface
{

    public function isGranted(array $user_profile, string $operation, ?Uuid $ressource_id = null): bool
    {
        $user_role = $user_profile['role'] ?? null;
        $user_id = $user_profile['id'] ?? null;

        switch ($operation) {
            case self::OPERATION_CREER_BOX:
                return $this->isAdmin($user_profile);
            case self::OPERATION_VIEW_BOX:
            case self::OPERATION_VALIDER_BOX:
            case self::OPERATION_ADD_PRESTA:
            case self::OPERATION_GENERER_URL:
                return $this->isAdmin($user_profile) && $this->isOwner($user_id, $ressource_id);

            default:
                return false;
        }
    }

    public function isAdmin(array $user_profile): bool
    {
        $role = $user_profile['role'] ?? null;
        return (int)$role >= 1;

    }

    public function isOwner(string $user_id, Uuid $ressource_id): bool
    {
        try {
            $box = \gift\appli\application_core\domain\entities\Box::where('id', $ressource_id->toString())->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
        return $box !== null && $box->user_id === $user_id;
        
    }
}