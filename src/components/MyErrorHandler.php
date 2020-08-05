<?php

namespace modava\product\components;


class MyErrorHandler extends \yii\web\ErrorHandler
{
    public $errorView = '@modava/product/views/error/error.php';

}