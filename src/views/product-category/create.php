<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modava\product\models\ProductCategory */

$this->title = Yii::t('product', 'Create Product Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
