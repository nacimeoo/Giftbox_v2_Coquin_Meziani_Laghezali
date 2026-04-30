<?php

require_once __DIR__ . '/../vendor/autoload.php';

use gift\appli\models\Categorie;
use Illuminate\Database\Capsule\Manager as DB;

$filename = __DIR__ . '/../conf/gift.db.conf.ini';
$conf = parse_ini_file($filename);

$db = new DB();
$db->addConnection($conf);
$db->setAsGlobal();
$db->bootEloquent();

echo "--- Test 2.b ---\n";
foreach (Categorie::all() as $categorie) {
    echo $categorie->id . " " . $categorie->libelle . "\n";
}