<?php

use modava\product\ProductModule;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modava\product\models\table\ProductCategoryTable;
use yii\helpers\ArrayHelper;
use modava\product\models\table\ProductTypeTable;
use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model modava\product\models\Product */
/* @var $form yii\widgets\ActiveForm */
\backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']);
?>

    <div class="product-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-8">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'language')
                    ->dropDownList(Yii::$app->params['availableLocales'], ['prompt' => Yii::t('backend', 'Chọn ngôn ngữ...')])
                    ->label(Yii::t('backend', 'Ngôn ngữ')) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'category_id')
                    ->dropDownList(ArrayHelper::map(ProductCategoryTable::getAllProductCategory($model->language), 'id', 'title'), ['prompt' => 'Chọn danh mục...'])
                    ->label('Danh mục sản phẩm') ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(ProductTypeTable::getAllProductType($model->language), 'id', 'title'), ['prompt' => 'Chọn loại...'])->label('Loại sản phẩm') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'price_sale')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'so_luong')->textInput(['maxlength' => true]) ?>
            </div>
        </div>


        <?= $form->field($model, 'description')->widget(\modava\tiny\TinyMce::class, [
            'options' => ['rows' => 6],
        ]) ?>

        <?= $form->field($model, 'content')->widget(\modava\tiny\TinyMce::class, [
            'options' => ['rows' => 10],
            'type' => 'content',
        ]) ?>
        <div class="row">
            <div class="col-8">
                <?= $form->field($model, 'product_tech')->widget(MultipleInput::class, [
                    'max' => 6,
                    'allowEmptyList' => true,
                    'columns' => [
                        [
                            'name' => 'product_tech',
                            'type' => 'dropDownList',
                            'title' => Yii::t('backend', 'Thuộc tính sản phẩm'),
                            'defaultValue' => 1,
                            'items' => Yii::$app->params['product_tech'],
                        ],
                        [
                            'name' => 'value',
                            'title' => Yii::t('backend', 'Giá trị'),
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ]
                    ]
                ])->label(false);
                ?>
            </div>
            <div class="col-4">
                <?php
                if (empty($model->getErrors()))
                    $path = Yii::$app->params['product']['150x150']['folder'];
                else
                    $path = null;
                echo \modava\tiny\FileManager::widget([
                    'model' => $model,
                    'attribute' => 'image',
                    'path' => $path,
                    'label' => Yii::t('backend', 'Hình ảnh') . ': ' . Yii::$app->params['product-size'],
                ]); ?>
            </div>
        </div>

        <?php if (Yii::$app->controller->action->id == 'create')
            $model->status = 1;
        ?>

        <?= $form->field($model, 'status')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php
$urlLoadCategories = Url::toRoute(['load-categories-by-lang']);
$urlLoadTypes = Url::toRoute(['load-types-by-lang']);
$script = <<< JS
function loadDataByLang(url, lang){
    return new Promise((resolve) => {
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            data: {
                lang: lang
            }
        }).done(res => {
            resolve(res);
        }).fail(f => {
            resolve(null);
        });
    });
}
$('body').on('change', '#product-language', async function(){
    var v = $(this).val(),
        categories, types;
    $('#product-category_id, #product-type_id').find('option[value!=""]').remove();
    await loadDataByLang('$urlLoadCategories', v).then(res => categories = res);
    await loadDataByLang('$urlLoadTypes', v).then(res => types = res);
    if(typeof categories === "string"){
        $('#product-category_id').append(categories);
    } else if(typeof categories === "object"){
        Object.keys(categories).forEach(function(k){
            $('#product-category_id').append('<option value="'+ k +'">'+ categories[k] +'</option>');
        });
    }
    if(typeof types === "string"){
        $('#product-type_id').append(types);
    } else if(typeof types === "object"){
        Object.keys(types).forEach(function(k){
            $('#product-type_id').append('<option value="'+ k +'">'+ types[k] +'</option>');
        });
    }
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);
