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
    ],
    'product_tech' => [
        'Đường kính dây thép' => 'Đường kính dây thép',
        'Kích thước ô lưới' => 'Kích thước ô lưới',
        'Chiều cao hàng rào' => 'Chiều cao hàng rào',
        'Bước cột' => 'Bước cột',
        'Quy cách trụ/ cột' => 'Quy cách trụ/ cột',
        'Hoàn thiện' => 'Hoàn thiện',
    ],
];
