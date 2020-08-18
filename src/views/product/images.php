<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use modava\product\ProductModule;
use modava\tiny\components\FileManagerPermisstion;
use modava\tiny\FileManagerAsset;
use modava\product\models\ProductImage;

/* @var $model modava\product\models\Product */

$this->title = 'Product Images: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => ProductModule::t('product', 'Product'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ProductModule::t('product', 'Images');

$css = <<< CSS
.hk-sec-wrapper .hk-gallery a {
    display: block;
    position: relative;
}
.hk-sec-wrapper .hk-gallery a .gallery-img {
    min-height: 160px;
    max-width: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
.del-image {
    position: absolute;
    top: -8px;
    right: -8px;
    color: red;
    border: solid 2px red;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    opacity: .6;
}
.hk-gallery a:hover .del-image {
    opacity: 1;
}
CSS;
$this->registerCss($css);
?>
    <div class="container-fluid px-xxl-25 px-xl-10">
        <?= \modava\product\widgets\NavbarWidgets::widget(); ?>

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                            class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
            </h4>
            <a class="btn btn-outline-light" href="<?= \yii\helpers\Url::to(['create']); ?>"
               title="<?= ProductModule::t('product', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= ProductModule::t('product', 'Create'); ?></a>
        </div>
        <!-- /Title -->

        <?php $form = ActiveForm::begin([
            'id' => 'form-product-images'
        ]) ?>
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row hk-gallery">
                        <?php
                        if (is_array($model->productImage)) {
                            foreach ($model->productImage as $productImage) {
                                $image = $productImage->getImage();
                                if ($image == null) continue;
                                ?>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6 mb-10 px-5"
                                     data-src="<?= $image ?>">
                                    <a href="#" class="d-block">
                                        <span class="del-image" data-image="<?= $productImage->id ?>">
                                            <i class="fa fa-times"></i>
                                        </span>
                                        <div class="gallery-img"
                                             style="background-image:url('<?= $image ?>');"></div>
                                    </a>
                                </div>
                            <?php }
                        } ?>
                        <div class="col-lg-2 col-md-4 col-sm-4 col-6 mb-10 px-5">
                            <?php
                            if (empty($model->getErrors()))
                                $path = Yii::$app->params['product']['150x150']['folder'];
                            else
                                $path = null;
                            echo \modava\tiny\FileManager::widget([
                                'model' => $model,
                                'attribute' => 'iptImages',
                                'path' => $path,
                                'label' => ProductModule::t('product', 'Hình ảnh') . ': ' . Yii::$app->params['product-size'],
                            ]); ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
<?php
$urlDelImage = \yii\helpers\Url::toRoute(['del-image']);
$script = <<< JS
function responsive_filemanager_callback(field_id){
    $('#form-product-images').submit();
}
$('body').on('click', '.del-image', function(){
    var data_image = $(this).attr('data-image');
    $.get('$urlDelImage', {
        'id': data_image
    }, res => {
        window.location.reload();
    });
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);