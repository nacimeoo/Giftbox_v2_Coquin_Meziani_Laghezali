<?php

namespace gift\core\domain\entities;

use Illuminate\Database\Eloquent\Model;

class CoffretType extends Model
{
    protected $table = 'coffret_type';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['id', 'libelle', 'description'];

    public function prestations() {
        return $this->belongsToMany(Prestation::class, 'coffret2presta', 'coffret_id', 'presta_id');
    }

    public function theme(){
        return $this->belongsTo(Theme::class, 'theme_id');
    }

}
    