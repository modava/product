<?php

namespace modava\product\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ProductAsset extends AssetBundle
{
    public $sourcePath = '@productweb';
    public $css = [

    ];
    public $js = [

    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
