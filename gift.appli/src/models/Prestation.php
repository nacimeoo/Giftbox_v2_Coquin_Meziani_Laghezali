<?php

namespace gift\appli\models;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['id', 'libelle', 'url', 'description', 'tarif', 'unite'];

    public function categorie() {
        return $this->belongsTo(related:Categorie::class, foreignKey:'cat_id');
    }



}
