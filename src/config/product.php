<?php
/**
 * Created by PhpStorm.
 * User: Kem Bi
 * Date: 06-Jul-18
 * Time: 4:00 PM
 */

use modava\product\components\MyErrorHandler;

$config = [
    'defaultRoute' => 'product/index',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'aliases' => [
        '@productweb' => '@modava/product/web',
    ],
    'components' => [
        'errorHandler' => [
            'class' => MyErrorHandler::class,
        ],
    ],
    'params' => require __DIR__ . '/params.php',
];

return $config;
