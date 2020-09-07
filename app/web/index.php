<?php

defined('YII_ENV') or define('YII_ENV', 'dev');
//define('YII_DEBUG', true);
require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/main.php');

$application = new yii\web\Application($config);
$application->run();