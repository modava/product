<?php
/**
 * Created by PhpStorm.
 * User: Kem Bi
 * Date: 06-Jul-18
 * Time: 4:42 PM
 */

use modava\product\ProductModule;

return [
    'availableLocales' => [
        'vi' => 'Tiếng Việt',
        'en' => 'English',
        'jp' => 'Japan',
    ],
    'productName' => 'Product',
    'productVersion' => '1.0',
    'status' => [
        '0' => ProductModule::t('product', 'Tạm ngưng'),
        '1' => ProductModule::t('product', 'Hiển thị'),
    ]
];
