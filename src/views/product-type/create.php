<?php

use modava\product\ProductModule;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modava\product\models\ProductType */

$this->title = ProductModule::t('product', 'Create');
$this->params['breadcrumbs'][] = ['label' => ProductModule::t('product', 'Product'), 'url' => ['/product']];
$this->params['breadcrumbs'][] = ['label' => ProductModule::t('product', 'Product type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= \modava\product\widgets\NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </section>
        </div>
    </div>

</div>
