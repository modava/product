<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modava\product\ProductModule;

/* @var $this yii\web\View */
/* @var $model modava\product\models\ProductCategory */
/* @var $form yii\widgets\ActiveForm */
\backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form'])
?>

<div class="product-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'language')
                ->dropDownList(Yii::$app->getModule('product')->params['availableLocales'], ['prompt' => ProductModule::t('product', 'Chọn ngôn ngữ...')])
                ->label(ProductModule::t('product', 'Ngôn ngữ')) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->widget(\modava\tiny\TinyMce::class, [
        'options' => ['rows' => 6],
    ]) ?>

    <?php if (Yii::$app->controller->action->id == 'create')
        $model->status = 1;
    ?>

    <?= $form->field($model, 'status')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton(ProductModule::t('product', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
