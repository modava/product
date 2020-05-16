<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modava\product\ProductModule;

/* @var $this yii\web\View */
/* @var $model modava\product\models\ProductCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => ProductModule::t('product', 'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(ProductModule::t('product', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(ProductModule::t('product', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => ProductModule::t('product', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'slug',
            'parent_id',
            'image',
            'description',
            'position',
            'ads_pixel:ntext',
            'ads_session:ntext',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
