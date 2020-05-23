<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use modava\product\ProductModule;

/* @var $this yii\web\View */
/* @var $searchModel modava\product\models\search\ProductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => ProductModule::t('product', 'Product'), 'url' => ['/product']];
$this->title = ProductModule::t('product', 'Product category');
$this->params['breadcrumbs'][] = $this->title;
\backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $searchModel->toastr_key . '-index']);
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

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">

                <?php Pjax::begin(); ?>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => '
                                    {errors}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            {items}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="dataTables_info" role="status" aria-live="polite">
                                                {pager}
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="dataTables_paginate paging_simple_numbers">
                                                {summary}
                                            </div>
                                        </div>
                                    </div>
                                ',
                                    'pager' => [
                                        'firstPageLabel' => ProductModule::t('product', 'First'),
                                        'lastPageLabel' => ProductModule::t('product', 'Last'),
                                        'prevPageLabel' => ProductModule::t('product', 'Previous'),
                                        'nextPageLabel' => ProductModule::t('product', 'Next'),
                                        'maxButtonCount' => 5,

                                        'options' => [
                                            'tag' => 'ul',
                                            'class' => 'pagination',
                                        ],

                                        // Customzing CSS class for pager link
                                        'linkOptions' => ['class' => 'page-link'],
                                        'activePageCssClass' => 'active',
                                        'disabledPageCssClass' => 'disabled page-disabled',
                                        'pageCssClass' => 'page-item',

                                        // Customzing CSS class for navigating link
                                        'prevPageCssClass' => 'paginate_button page-item',
                                        'nextPageCssClass' => 'paginate_button page-item',
                                        'firstPageCssClass' => 'paginate_button page-item',
                                        'lastPageCssClass' => 'paginate_button page-item',
                                    ],
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'header' => 'STT',
                                            'headerOptions' => [
                                                'width' => 50,
                                            ],
                                        ],

                                        'title',
//                                        'image',
                                        'description:html',
                                        //'position',
                                        //'ads_pixel:ntext',
                                        //'ads_session:ntext',
                                        [
                                            'attribute' => 'language',
                                            'value' => function ($model) {
                                                return Yii::$app->getModule('product')->params['availableLocales'][$model->language];
                                            },
                                            'headerOptions' => [
                                                'width' => 150,
                                            ],
                                        ],
                                        [
                                            'attribute' => 'status',
                                            'value' => function ($model) {
                                                return Yii::$app->getModule('product')->params['status'][$model->status];
                                            },
                                            'headerOptions' => [
                                                'width' => 150,
                                            ],
                                        ],
                                        [
                                            'attribute' => 'created_at',
                                            'format' => 'date',
                                            'headerOptions' => [
                                                'width' => 150,
                                            ],
                                        ],
                                        //'updated_at',
                                        [
                                            'attribute' => 'created_by',
                                            'value' => 'userCreated.userProfile.fullname',
                                            'headerOptions' => [
                                                'width' => 150,
                                            ],
                                        ],
                                        //'updated_by',

                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => ProductModule::t('product', 'Actions'),
                                            'headerOptions' => [
                                                'width' => 150,
                                            ],
                                        ],
                                    ],
                                ]); ?>

                            </div>
                        </div>
                    </div>
                </div>

                <?php Pjax::end(); ?>
            </section>
        </div>
    </div>

</div>