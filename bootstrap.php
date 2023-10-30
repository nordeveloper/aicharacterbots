<?php
require __DIR__."/vendor/autoload.php";
require(__DIR__.'/config.php');

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
   "driver" => "mysql",
   "host" =>( !empty($dbconfig['dbhost'])? $dbconfig['dbhost'] : "localhost" ),
   "database" => ( !empty($dbconfig['dbname'])? $dbconfig['dbname'] : "charai" ),
   "username" => ( !empty($dbconfig['dbuser'])? $dbconfig['dbuser'] : "root" ),
   "password" => ( !empty($dbconfig['dbpass'])? $dbconfig['dbpass'] : "" ),
   'charset'   => 'utf8mb4',
   'collation' => 'utf8mb4_general_ci'
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();