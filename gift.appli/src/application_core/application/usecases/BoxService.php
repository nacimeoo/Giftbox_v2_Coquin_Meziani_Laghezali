<?php

namespace gift\appli\application_core\application\usecases;

use gift\appli\application_core\domain\entities\Box;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BoxService implements BoxInterface
{
    public function generateToken(string $boxId, string $userId): string
    {
        try {
            $box = Box::findOrFail($boxId);
            
            $token = $box->genererToken($userId);

            $box->save();

            return $token;
            
        } catch (ModelNotFoundException $e) {
            throw new Exception("Box introuvable.");
        }
    }

    public function getBoxByToken(string $token): array
    {
        try {
            $box = Box::with('prestations')->where('token', $token)->firstOrFail();
            
            $box->Utilisee();
            $box->save();

            return $box->toArray();
            
        } catch (ModelNotFoundException $e) {
            throw new Exception("URL invalide ou Box introuvable.");
        }
    }
}