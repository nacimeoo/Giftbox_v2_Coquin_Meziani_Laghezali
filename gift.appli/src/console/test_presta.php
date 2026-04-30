<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use gift\appli\models\Prestation;
use gift\appli\utils\Eloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;

Eloquent::init(__DIR__ . '/../conf/gift.db.conf.ini');

$id = $argv[1] ?? null;

try {
    $prestation = Prestation::findOrFail($id);

    echo "ID : " . $prestation->id . "\n";
    echo "Libelle : " . $prestation->libelle . "\n";
    echo "Description : " . $prestation->description . "\n";
    echo "Tarif : " . $prestation->tarif . "\n";
    echo "Unite : " . $prestation->unite . "\n";
} catch (ModelNotFoundException $e) {
    echo "ya pas " . $id . "\n";
}
