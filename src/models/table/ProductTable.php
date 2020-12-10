<?php

namespace modava\product\models\table;

use backend\components\MyModel;
use modava\product\models\ProductCategory;
use modava\product\models\ProductType;
use modava\product\models\query\ProductQuery;
use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $product_code
 * @property int $category_id
 * @property int $type_id
 * @property string $title
 * @property string $slug
 * @property string|null $image
 * @property string|null $price
 * @property string|null $price_sale
 * @property string|null $so_luong
 * @property string|null $description
 * @property string|null $content
 * @property int $product_hot
 * @property string|null $product_tech
 * @property int|null $position
 * @property string|null $ads_pixel
 * @property string|null $ads_session
 * @property int $status
 * @property int|null $views
 * @property string $language Language for yii2
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 */
class ProductTable extends MyModel
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DISABLED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-product-table-get-by-id-' . $this->id . '-' . $this->language,
            'redis-product-table-get-all-' . $this->language,
            'redis-product-table-get-products-by-category-' . $this->category_id . '-' . $this->language
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function afterDelete()
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-product-table-get-by-id-' . $this->id . '-' . $this->language,
            'redis-product-table-get-all-' . $this->language,
            'redis-product-table-get-products-by-category-' . $this->category_id . '-' . $this->language
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        parent::afterDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProductType::class, ['id' => 'type_id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImage()
    {
        return $this->hasMany(ProductImageTable::class, ['product_id' => 'id']);
    }

    /**
     * @param string|null $size
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function getImage(string $size = null)
    {
        $image = $this->image;
        if (!isset(Yii::$app->params['product'])) {
            $size = '150x150';
            $image = 'no-image.png';
        }
        if (!array_key_exists($size, Yii::$app->params['product'])) $size = array_keys(Yii::$app->params['product'])[0];
        if (is_dir(Yii::getAlias('@frontend/web') . Yii::$app->params['product'][$size]['folder'] . $image) || !file_exists(Yii::getAlias('@frontend/web') . Yii::$app->params['product'][$size]['folder'] . $image)) {
            $size = '150x150';
            $image = 'no-image.png';
        }
        return Yii::$app->assetManager->publish(Yii::getAlias('@frontend/web') . Yii::$app->params['product'][$size]['folder'] . $image)[1];
    }

    /**
     * @param $id
     * @param null $language
     * @return array|mixed|\yii\db\ActiveRecord|null
     */
    public static function getById($id, $language = null)
    {
        $language = $language ?: Yii::$app->language;
        $cache = Yii::$app->cache;
        $key = 'redis-product-table-get-by-id-' . $id . '-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where([self::tableName() . '.id' => $id, self::tableName() . '.language' => $language])->published()->one();
            $cache->set($key, $data);
        }
        return $data;
    }

    /**
     * @param null $language
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public static function getAll($language = null)
    {
        $language = $language ?: Yii::$app->language;
        $cache = Yii::$app->cache;
        $key = 'redis-product-table-get-all-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where([self::tableName() . '.language' => $language])->published()->all();
            $cache->set($key, $data);
        }
        return $data;
    }

    /**
     * @param $category_id
     * @param null $language
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public static function getProductsByCategory($category_id, $language = null)
    {
        $language = $language ?: Yii::$app->language;
        $cache = Yii::$app->cache;
        $key = 'redis-product-table-get-products-by-category-' . $category_id . '-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where([self::tableName() . '.category_id' => $category_id, self::tableName() . '.language' => $language])->published()->all();
            $cache->set($key, $data);
        }
        return $data;
    }
}
