<?php

use modava\product\ProductModule;
use common\grid\MyGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel modava\product\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Product');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container-fluid px-xxl-25 px-xl-10">
        <?= \modava\product\widgets\NavbarWidgets::widget(); ?>

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                            class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
            </h4>
            <a class="btn btn-outline-light btn-sm" href="<?= \yii\helpers\Url::to(['create']); ?>"
               title="<?= Yii::t('backend', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= Yii::t('backend', 'Create'); ?></a>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper index">

                    <?php Pjax::begin(['id' => 'product', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]); ?>
                    <?php echo \backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $searchModel->toastr_key . '-index']); ?>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <?= MyGridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'layout' => '
                                            {errors} 
                                            <div class="pane-single-table">
                                                {items}
                                            </div>
                                            <div class="pager-wrap clearfix">
                                                {summary}' .
                                            Yii::$app->controller->renderPartial('@backend/views/layouts/my-gridview/_pageTo', [
                                                'totalPage' => $totalPage,
                                                'currentPage' => Yii::$app->request->get($dataProvider->getPagination()->pageParam)
                                            ]) .
                                            Yii::$app->controller->renderPartial('@backend/views/layouts/my-gridview/_pageSize') .
                                            '{pager}
                                            </div>
                                        ',
                                        'tableOptions' => [
                                            'id' => 'dataTable',
                                            'class' => 'dt-grid dt-widget pane-hScroll',
                                        ],
                                        'myOptions' => [
                                            'class' => 'dt-grid-content my-content pane-vScroll',
                                            'data-minus' => '{"0":105,"1":".hk-navbar","2":".nav-tabs","3":".hk-pg-header","4":".hk-footer-wrap"}'
                                        ],
                                        'summaryOptions' => [
                                            'class' => 'summary pull-right',
                                        ],
                                        'pager' => [
                                            'firstPageLabel' => Yii::t('backend', 'First'),
                                            'lastPageLabel' => Yii::t('backend', 'Last'),
                                            'prevPageLabel' => Yii::t('backend', 'Previous'),
                                            'nextPageLabel' => Yii::t('backend', 'Next'),
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
                                            'prevPageCssClass' => 'paginate_button page-item prev',
                                            'nextPageCssClass' => 'paginate_button page-item next',
                                            'firstPageCssClass' => 'paginate_button page-item first',
                                            'lastPageCssClass' => 'paginate_button page-item last',
                                        ],
                                        'columns' => [
                                            [
                                                'class' => 'yii\grid\SerialColumn',
                                                'header' => 'STT',
                                                'headerOptions' => [
                                                    'width' => 50,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'image',
                                                'format' => 'html',
                                                'value' => function ($model) {
                                                    if ($model->image == null)
                                                        return null;
                                                    return Html::img(Yii::$app->params['product']['150x150']['folder'] . $model->image, ['width' => 50, 'height' => 50]);
                                                },
                                                'headerOptions' => [
                                                    'width' => 80,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'title',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a($model->title, ['view', 'id' => $model->id], [
                                                        'title' => $model->title,
                                                        'data-pjax' => 0,
                                                    ]);
                                                }
                                            ],
                                            [
                                                'attribute' => 'product_code',
                                                'headerOptions' => [
                                                    'width' => 100,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'category_id',
                                                'value' => 'category.title',
                                                'label' => 'Danh mục',
                                                'headerOptions' => [
                                                    'width' => 120,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'type_id',
                                                'value' => 'type.title',
                                                'label' => 'Loại Sp',
                                                'headerOptions' => [
                                                    'width' => 120,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'price',
                                                'headerOptions' => [
                                                    'width' => 120,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'status',
                                                'value' => function ($model) {
                                                    return Yii::$app->getModule('product')->params['status'][$model->status];
                                                },
                                                'headerOptions' => [
                                                    'width' => 120,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'product_hot',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return \modava\input\Checkbox::widget([
                                                        'id' => $model->id,
                                                        'value' => $model->product_hot,
                                                    ]);
                                                },
                                                'headerOptions' => [
                                                    'width' => 70,
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
                                                    'width' => 120,
                                                ],
                                            ],
                                            //'updated_by',

                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'header' => Yii::t('backend', 'Actions'),
                                                'template' => '{images} {update} {delete}',
                                                'buttons' => [
                                                    'images' => function ($url, $model) {
                                                        return Html::a('<span class="ion ion-md-images"></span>', $url, [
                                                            'title' => Yii::t('backend', 'Images'),
                                                            'alia-label' => Yii::t('backend', 'Images'),
                                                            'data-pjax' => 0,
                                                            'class' => 'btn btn-green btn-xs'
                                                        ]);
                                                    },
                                                    'update' => function ($url, $model) {
                                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                            'title' => Yii::t('backend', 'Update'),
                                                            'alia-label' => Yii::t('backend', 'Update'),
                                                            'data-pjax' => 0,
                                                            'class' => 'btn btn-info btn-xs'
                                                        ]);
                                                    },
                                                    'delete' => function ($url, $model) {
                                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:;', [
                                                            'title' => Yii::t('backend', 'Delete'),
                                                            'class' => 'btn btn-danger btn-xs btn-del',
                                                            'data-title' => Yii::t('backend', 'Delete?'),
                                                            'data-pjax' => 0,
                                                            'data-url' => $url,
                                                            'btn-success-class' => 'success-delete',
                                                            'btn-cancel-class' => 'cancel-delete',
                                                            'data-placement' => 'top'
                                                        ]);
                                                    }
                                                ],
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
<?php
$urlChangePageSize = \yii\helpers\Url::toRoute(['perpage']);
$urlCheckHot = \yii\helpers\Url::toRoute(['check-hot']);
$script = <<< JS
var customPjax = new myGridView();
customPjax.init({
    pjaxId: '#product',
    urlChangePageSize: '$urlChangePageSize',
});
$('body').on('click', '.success-delete', function(e){
    e.preventDefault();
    var url = $(this).attr('href') || null;
    if(url !== null){
        $.post(url);
    }
    return false;
});
$(document).ready(function () {
    $('body').on('change', '.check-toggle', function (e) {
        e.preventDefault();
        var currentUrl = $(location).attr('href');
        var id = $(this).val();
        $.post('$urlCheckHot', {id: id}, function (res) {
            $.pjax.reload({
                url: currentUrl,
                method: 'POST',
                container: '#product'
            });
        });
        return false;
    });
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);