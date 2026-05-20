<?php

namespace gift\core\domain\entities;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['libelle','description'];

    public function prestations() {
        return $this->hasMany(related: Prestation::class, foreignKey:'cat_id');
    }

}


 