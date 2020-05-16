<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modava\product\ProductModule;

/* @var $this yii\web\View */
/* @var $model modava\product\models\ProductCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(\modava\tiny\TinyMce::class, [
        'options' => ['rows' => 6],
    ]) ?>

    <?= \modava\tiny\FileManager::widget([
        'model' => $model,
        'attribute' => 'image',
        'label' => ProductModule::t('product', 'Hình ảnh') . ': 150x150px'
    ]); ?>

    <?php if (Yii::$app->controller->action->id == 'create')
        $model->status = 1;
    ?>

    <?= $form->field($model, 'status')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton(ProductModule::t('product', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
