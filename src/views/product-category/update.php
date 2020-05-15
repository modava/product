<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modava\product\models\ProductCategory */

$this->title = Yii::t('product', 'Update Product Category: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('product', 'Update');
?>
<div class="product-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
