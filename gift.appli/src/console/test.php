<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use gift\appli\models\CoffretType;
use gift\appli\utils\Eloquent;

Eloquent::init(__DIR__ . '/../conf/gift.db.conf.ini');

$coffrets = CoffretType::all();


foreach ($coffrets as $coffret) {
	echo "ID : " . $coffret->id . "\n";
    echo "Libelle : " . $coffret->libelle . "\n";
    echo "Description : " . $coffret->description . "\n";
    echo "them id: " . $coffret->theme_id . "\n";
}
