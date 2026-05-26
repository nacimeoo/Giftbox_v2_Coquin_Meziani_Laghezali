<?php

namespace gift\appli\application_core\domain\entities;
use Illuminate\Database\Eloquent\Model;
use gift\appli\application_core\domain\Exception\UnauthorizedAccessException;
use gift\appli\application_core\domain\Exception\BoxAlreadyValidatedException;
use gift\appli\application_core\domain\Exception\NotEnoughPrestationsException;
use Exception;

class Box extends Model
{

    public const STATUT_CREEE = 1;
    public const STATUT_VALIDEE = 2;
    public const STATUT_LIVREE = 3;
    public const STATUT_UTILISEE = 4;
    
    protected $table = 'box';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id', 'token', 'libelle', 'description',
        'montant', 'kdo', 'message_kdo',
        'statut', 'created_at', 'updated_at', 'createur_id'
    ];

    public function prestations() {
        return $this->belongsToMany(Prestation::class, 'box2presta', 'box_id', 'presta_id')->withPivot('quantite');
    }

    public function genererToken(string $userId): string
    {
        if ($this->createur_id !== $userId) {
            throw new Exception("Opération non autorisée.");
        }

        if ($this->statut < self::STATUT_VALIDEE) {
            throw new Exception("La box doit être validée pour générer une URL.");
        }

        if (!empty($this->token)) {
            return $this->token;
        }

        $this->token = bin2hex(random_bytes(32));
        $this->statut = self::STATUT_LIVREE;

        return $this->token;
    }

    public function Utilisee(): void
    {
        if ($this->statut === self::STATUT_LIVREE) {
            $this->statut = self::STATUT_UTILISEE;
        }
    }

    public function verifierProprietaire(string $userId): void
    {
        if ($this->createur_id !== $userId) {
            throw new UnauthorizedAccessException("Accès refusé : vous n'êtes pas le propriétaire de cette box.");
        }
    }

    public function verifierModifiable(): void
    {
        if ($this->statut >= self::STATUT_VALIDEE) {
            throw new BoxAlreadyValidatedException("Opération impossible : la box est déjà validée.");
        }
    }

    public function valider(string $userId, int $nbPrestations): void
    {
        $this->verifierProprietaire($userId);
        $this->verifierModifiable();

        if ($nbPrestations < 2) {
            throw new NotEnoughPrestationsException("Une box doit contenir au moins 2 prestations différentes pour être validée.");
        }

        $this->statut = self::STATUT_VALIDEE;
        $this->updated_at = date('Y-m-d H:i:s');
    }





}


 