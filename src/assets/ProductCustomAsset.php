<?php

namespace modava\product\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ProductCustomAsset extends AssetBundle
{
    public $sourcePath = '@productweb';
    public $css = [
        'css/customProduct.css'
    ];
    public $js = [
        'js/customProduct.js'
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
