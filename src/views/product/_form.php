<?php

use modava\product\ProductModule;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modava\product\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'language')->dropDownList(Yii::$app->getModule('product')->params['availableLocales'])->label(ProductModule::t('product', 'Ngôn ngữ')) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'category_id')->textInput() ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'type_id')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_sale')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'so_luong')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(\modava\tiny\TinyMce::class, [
        'options' => ['rows' => 6],
    ]) ?>

    <?= $form->field($model, 'content')->widget(\modava\tiny\TinyMce::class, [
        'options' => ['rows' => 10],
        'type' => 'content',
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
        <?= Html::submitButton(Yii::t('product', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
