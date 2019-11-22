<?php
require_once "vendor/autoload.php";
require_once "env.php";
require_once "app/config/Constants.php";

use Slim\App;
use Psr\Http\Message\MessageInterface as RQ;
use Config\Config;
use Config\Routes;
use Psr\Http\Message\MessageInterface;

$app = new App(Config::getSlimConfig());

new Routes($app);

$app->run();