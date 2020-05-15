<?php
/**
 * Created by PhpStorm.
 * User: Kem Bi
 * Date: 06-Jul-18
 * Time: 4:42 PM
 */

use modava\product\Product;

return [
    'productName' => 'Product',
    'productVersion' => '1.0',
    'status' => [
        '0' => Product::t('product', 'Tạm ngưng'),
        '1' => Product::t('product', 'Hiển thị'),
    ]
];
