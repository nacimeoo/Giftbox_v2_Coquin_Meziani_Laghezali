<?php

namespace gift\appli\src\models;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function categorie() {
        return $this->belongsTo(Categorie::class, 'cat_id');
    }

    public function boxe() {
        return $this->belongsToMany(Box::class, 'box2presta', 'presta_id', 'box_id')
                    ->withPivot('quantite');
    }

    public function coffret() {
        return $this->belongsToMany(CoffretType::class, 'coffret2presta', 'presta_id', 'coffret_id');
    }
}
