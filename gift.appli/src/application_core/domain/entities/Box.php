<?php

namespace gift\appli\application_core\domain\entities;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    
    protected $table = 'box';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id', 'token', 'libelle', 'description',
        'montant', 'kdo', 'message_kdo',
        'statut', 'created_at', 'updated_at', 'createur_id'
    ];

    public function prestations() {
        return $this->belongsToMany(Prestation::class, 'box2presta', 'box_id', 'presta_id')->withPivot('quantite');
    }

}


 