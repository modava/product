<?php

namespace modava\product;

use yii\base\BootstrapInterface;
use Yii;
use yii\base\Event;
use \yii\base\Module;
use yii\web\Application;
use yii\web\Controller;

/**
 * Product module definition class
 */
class ProductModule extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'modava\product\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        // custom initialization code goes here
        $this->registerTranslations();
        parent::init();
        Yii::configure($this, require(__DIR__ . '/config/product.php'));
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
        $this->layout = 'product';
    }

    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_ACTION, function () {

        });
        Event::on(Controller::class, Controller::EVENT_BEFORE_ACTION, function (Event $event) {
            $controller = $event->sender;
        });
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['product/messages/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@modava/product/messages',
            'fileMap' => [
                'product/messages/product' => 'product.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('product/messages/' . $category, $message, $params, $language);
    }
}
