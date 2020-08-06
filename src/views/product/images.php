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

$insFile = FileManagerAsset::register($this);
$link = $insFile->baseUrl . '/filemanager/';
$configPath = [
    'upload_dir' => ProductImage::getUploadDir(),
    'base_url' => ProductImage::getBaseUrl(),
    'FileManagerPermisstion' => FileManagerPermisstion::setPermissionFileAccess()
];
$filemanager_access_key = urlencode(serialize($configPath));

$css = <<< CSS
.img-select-content {
    position: relative;
    display: inline-block;
}
.remove-img {
    position: absolute;
    color: red;
    border: solid 1px red;
    height: 20px;
    width: 20px;
    align-items: center;
    justify-content: center;
    top: -5px;
    right: -5px;
    display: flex;
    opacity: 0;
    z-index: -1;
    cursor: pointer;
    background: #fff;
    border-radius: 3px;
}
.has-img .remove-img {
    opacity: 1;
    z-index: 1;
}
.upload-img-zone {
    z-index: 2;
    background: url(https://cdn3.iconfinder.com/data/icons/glypho-generic-icons/64/action-upload-alt-512.png) center center;
    background-size: contain;
}
.upload-img-zone, .upload-img-zone:before {
    content: "";
    position: absolute;
    top: 30%;
    left: 30%;
    right: 30%;
    bottom: 30%;
    z-index: -1;
    opacity: 0;
    transition: all .4s ease;
}
.img-select:hover .upload-img-zone, .img-select:hover .upload-img-zone:before {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    opacity: 1;
}
.image-modal {
    height: 160px;
    padding: .25rem;
    background-color: #f5f7fa;
    border: 1px solid #ddd;
    border-radius: .25rem;
}
.hk-sec-wrapper .hk-gallery a {
    display: block;
}
.hk-sec-wrapper .hk-gallery a .gallery-img {
    min-height: 160px;
    max-width: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
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
                                    <a href="#" class="">
                                        <div class="gallery-img"
                                             style="background-image:url('<?= $image ?>');"></div>
                                    </a>
                                </div>
                            <?php }
                        } ?>
                        <div class="col-lg-2 col-md-4 col-sm-4 col-6 mb-10 px-5 gallery-content img-select-content">
                            <div class="img-select" data-toggle="modal" data-target="#file-manager">
                                <div class="image-modal"></div>
                                <div class="upload-img-zone"></div>
                                <div class="d-none">
                                    <?= $form->field($model, 'iptImages')->textInput([
                                        'id' => 'iptImages'
                                    ]) ?>
                                </div>
                            </div>
                            <span class="remove-img delete"><i class="fa fa-times"></i></span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="file-manager" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= Yii::t('backend', 'File Manager'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="<?= $link; ?>/dialog.php?type=2&field_id=iptImages&lang=vi&akey=<?= $filemanager_access_key; ?>"
                            style="width: 100%; height: 900px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal"><?= Yii::t('backend', 'Close'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php
$script = <<< JS
function responsive_filemanager_callback(field_id){
    $('#form-product-images').submit();
}
JS;
$this->registerJs($script, \yii\web\View::POS_END);