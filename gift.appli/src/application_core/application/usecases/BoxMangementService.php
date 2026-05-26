<?php

namespace gift\appli\application_core\application\usecases;

use gift\appli\application_core\domain\entities\Box;
use gift\appli\application_core\domain\entities\Prestation;
use gift\appli\application_core\domain\Exception\BoxNotFoundException;
use gift\appli\application_core\domain\Exception\UnauthorizedAccessException;
use gift\appli\application_core\domain\Exception\BoxAlreadyValidatedException;
use gift\appli\application_core\domain\Exception\NotEnoughPrestationsException;
use gift\appli\application_core\application\usecases\BoxMangementInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BoxMangementService implements BoxMangementInterface
{
    public function createBox(array $data, string $userId): string
    {
        if (empty($data['libelle'])) {
            throw new \InvalidArgumentException("Le libellé de la box est obligatoire.");
        }

        $box = new Box();
        $box->id = bin2hex(random_bytes(16));        
        $box->token = ''; 
        
        $box->libelle = $data['libelle'];
        $box->description = $data['description'] ?? null;
        $box->montant = 0.00; 
        $box->kdo = $data['kdo'] ?? 0;
        $box->message_kdo = $data['message_kdo'] ?? '';
        $box->statut = Box::STATUT_CREEE; 
        $box->createur_id = $userId;
        $box->created_at = date('Y-m-d H:i:s');
        $box->updated_at = date('Y-m-d H:i:s');

        $box->save();

        return $box->id;
    }

    public function addPrestationToBox(string $boxId, string $prestaId, string $userId): void
    {
        try {
            $box = Box::findOrFail($boxId);
        } catch (ModelNotFoundException $e) {
            throw new BoxNotFoundException("La box demandée n'existe pas.");
        }

        $box->verifierProprietaire($userId);
        $box->verifierModifiable();

        if (!Prestation::where('id', $prestaId)->exists()) {
            throw new \InvalidArgumentException("La prestation demandée n'existe pas.");
        }

        $existingPresta = $box->prestations()->where('presta_id', $prestaId)->first();

        if ($existingPresta) {
            $nouvelleQte = $existingPresta->pivot->quantite + 1;
            $box->prestations()->updateExistingPivot($prestaId, ['quantite' => $nouvelleQte]);
        } else {
            $box->prestations()->attach($prestaId, ['quantite' => 1]);
        }

        $this->updateBoxMontant($box);
    }

    public function getBoxWithPrestations(string $boxId, string $userId): array
    {
        try {
            $box = Box::with('prestations')->findOrFail($boxId);
        } catch (ModelNotFoundException $e) {
            throw new BoxNotFoundException("La box demandée n'existe pas.");
        }

        $box->verifierProprietaire($userId);

        return $box->toArray();
    }

    public function validerBox(string $boxId, string $userId): void
    {
        try {
            $box = Box::with('prestations')->findOrFail($boxId);
        } catch (ModelNotFoundException $e) {
            throw new BoxNotFoundException("La box demandée n'existe pas.");
        }

        $box->valider($userId, $box->prestations->count());

        $box->save();
    }

    
    private function updateBoxMontant(Box $box): void
    {
        $total = 0.00;
        
        $box->load('prestations');
        
        foreach ($box->prestations as $prestation) {
            $total += $prestation->tarif * $prestation->pivot->quantite;
        }

        $box->montant = $total;
        $box->save();
    }
}