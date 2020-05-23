<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modava\product\ProductModule;

/* @var $this yii\web\View */
/* @var $model modava\product\models\ProductCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => ProductModule::t('product', 'Product'), 'url' => ['/product']];
$this->params['breadcrumbs'][] = ['label' => ProductModule::t('product', 'Product category'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
\backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-view'])
?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= \modava\product\widgets\NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <p>
            <a class="btn btn-outline-light" href="<?= \yii\helpers\Url::to(['create']); ?>"
               title="<?= ProductModule::t('product', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= ProductModule::t('product', 'Create'); ?></a>
            <?= Html::a(ProductModule::t('product', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(ProductModule::t('product', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => ProductModule::t('product', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'title',
                        'slug',
                        'parent_id',
                        'image',
                        'description:html',
                        'position',
                        'ads_pixel:html',
                        'ads_session:html',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return Yii::$app->getModule('product')->params['status'][$model->status];
                            }
                        ],
                        [
                            'attribute' => 'language',
                            'value' => function ($model) {
                                return Yii::$app->getModule('article')->params['availableLocales'][$model->language];
                            },
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'userCreated.userProfile.fullname',
                            'label' => ProductModule::t('product', 'Created By')
                        ],
                        [
                            'attribute' => 'userUpdated.userProfile.fullname',
                            'label' => ProductModule::t('product', 'Updated By')
                        ],
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>
