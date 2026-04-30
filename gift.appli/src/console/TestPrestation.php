<?php
require_once __DIR__ . '/../vendor/autoload.php';

use gift\appli\utils\Eloquent;
use gift\appli\models\Prestation;

$filename = __DIR__ . '/../conf/gift.db.conf.ini';
Eloquent::init($filename);

/*
$prestations = Prestation::all();


foreach ($prestations as $presta) {
    echo "Libellé     : " . $presta->libelle . "\n";
    echo "Description : " . $presta->description . "\n";
    echo "Tarif       : " . $presta->tarif . " €\n";
    echo "Unité       : " . $presta->unite . "\n";
}
*/


// question 4 c
$prestations = Prestation::all();

foreach ($prestations as $presta) {
    $nomCategorie = $presta->categorie->libelle; 
    echo "- " . $presta->libelle . " | Catégorie : " . $nomCategorie . "\n";
}


echo " version 2 \n";

$prestations = Prestation::with('categorie')->get();

foreach ($prestations as $presta) {
    $nomCategorie = $presta->categorie->libelle;
    echo "- " . $presta->libelle . " | Catégorie : " . $nomCategorie . "\n";
}
