<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Compagnie, Jeu, Plateforme};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');