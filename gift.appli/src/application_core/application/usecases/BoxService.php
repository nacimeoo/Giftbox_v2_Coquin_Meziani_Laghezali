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
            
            if ($box->createur_id !== $userId) {
                throw new Exception("Opération non autorisée.");
            }

            if ($box->statut < 2) {
                throw new Exception("La box doit être validée pour générer une URL.");
            }

            if (!empty($box->token)) {
                return $box->token; 
            }

            $token = bin2hex(random_bytes(32));
            $box->token = $token;
            $box->statut = 3;
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
            
            if ($box->statut === 3) {
                $box->statut = 4;
                $box->save();
            }

            return $box->toArray();
            
        } catch (ModelNotFoundException $e) {
            throw new Exception("URL invalide ou Box introuvable.");
        }
    }
}