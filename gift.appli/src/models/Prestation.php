<?php

namespace gift\appli\src\models;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    public function categorie() {
        return $this->belongsTo(Categorie::class, 'cat_id');
    }

}
