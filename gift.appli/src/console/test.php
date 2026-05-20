<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use gift\core\domain\entities\CoffretType;
use gift\core\domain\entities\Prestation;
use gift\core\domain\entities\Categorie;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use gift\appli\utils\Eloquent;

Eloquent::init(__DIR__ . '/../conf/.database_env');

$coffrets = CoffretType::all();

$filename = __DIR__ . '/../conf/.database_env';
$conf = parse_ini_file($filename);

$db = new DB();
$db->addConnection($conf);
$db->setAsGlobal();
$db->bootEloquent();

foreach ($coffrets as $coffret) {
    echo "ID : " . $coffret->id . "\n";
    echo "Libelle : " . $coffret->libelle . "\n";
    echo "Description : " . $coffret->description . "\n";
    echo "theme id: " . $coffret->theme_id . "\n";
    echo "Prestations suggérées :\n";
    foreach ($coffret->prestations as $prestation) {
        echo "  - [{$prestation->id}] {$prestation->libelle} ({$prestation->tarif} {$prestation->unite})\n";
    }
    echo "\n";
}

$id = $argv[1] ?? null;

try {
    $prestation = Prestation::find($id);

    echo "ID : " . $prestation->id . "\n";
    echo "Libelle : " . $prestation->libelle . "\n";
    echo "Description : " . $prestation->description . "\n";
    echo "Tarif : " . $prestation->tarif . "\n";
    echo "Unite : " . $prestation->unite . "\n";
} catch (ModelNotFoundException $e) {
    echo "ya pas " . $id . "\n";
}

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

$db = new DB();
$db->addConnection($conf);
$db->setAsGlobal();
$db->bootEloquent();

echo "Test 2.b\n";
foreach (Categorie::all() as $categorie) {
    echo $categorie->id . " " . $categorie->libelle . "\n";
}

echo "Test 4.b\n";
$categorie = Categorie::find(3);
    echo "Catégorie 3 : {$categorie->libelle}\n";
    echo "Prestations associées :\n";
    foreach ($categorie->prestations as $prestation) {
        echo "- {$prestation->id} : {$prestation->libelle} ({$prestation->tarif} {$prestation->unite})\n";
    }
