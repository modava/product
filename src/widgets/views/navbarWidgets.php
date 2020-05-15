<?php

use yii\helpers\Url;
use modava\product\Product;

?>
<ul class="nav nav-tabs nav-sm nav-light mb-25">
    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'product') echo ' active' ?>"
           href="<?= Url::toRoute(['/product']); ?>">
            <i class="ion ion-ios-book"></i><?= Product::t('product', 'Product'); ?>
        </a>
    </li>

    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'product-category') echo ' active' ?>"
           href="<?= Url::toRoute(['/product/product-category']); ?>"><i
                    class="ion ion-md-apps"></i><?= Product::t('product', 'Product category'); ?></a>
    </li>

    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'product-type') echo ' active' ?>"
           href="<?= Url::toRoute(['/product/product-type']); ?>"><i
                    class="ion ion-md-transgender"></i><?= Product::t('article', 'Product type'); ?></a>
    </li>
</ul>
