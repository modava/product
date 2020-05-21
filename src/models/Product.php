<?php

namespace modava\product\models;

use common\helpers\MyHelper;
use common\models\User;
use modava\product\models\table\ProductTable;
use modava\product\ProductModule;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;


class Product extends ProductTable
{

    public function behaviors()
    {

        return array_merge(
            parent::behaviors(),
            [
                'slug' => [
                    'class' => SluggableBehavior::class,
                    'immutable' => false,
                    'ensureUnique' => true,
                    'value' => function () {
                        return MyHelper::createAlias($this->title);
                    }
                ],
                [
                    'class' => BlameableBehavior::class,
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
                'timestamp' => [
                    'class' => 'yii\behaviors\TimestampBehavior',
                    'preserveNonEmptyValues' => true,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'type_id', 'title'], 'required'],
            [['category_id', 'type_id', 'position', 'status', 'views', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description', 'content', 'ads_pixel', 'ads_session', 'language'], 'string'],
            ['language', 'in', 'range' => ['vi', 'en', 'jp'], 'strict' => false],
            [['product_code'], 'string', 'max' => 25],
            [['title', 'slug', 'image', 'price', 'price_sale', 'so_luong'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::class, 'targetAttribute' => ['type_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => ProductModule::t('product', 'ID'),
            'product_code' => ProductModule::t('product', 'Product Code'),
            'category_id' => ProductModule::t('product', 'Category ID'),
            'type_id' => ProductModule::t('product', 'Type ID'),
            'title' => ProductModule::t('product', 'Title'),
            'slug' => ProductModule::t('product', 'Slug'),
            'image' => ProductModule::t('product', 'Image'),
            'price' => ProductModule::t('product', 'Price'),
            'price_sale' => ProductModule::t('product', 'Price Sale'),
            'so_luong' => ProductModule::t('product', 'So Luong'),
            'description' => ProductModule::t('product', 'Description'),
            'content' => ProductModule::t('product', 'Content'),
            'position' => ProductModule::t('product', 'Position'),
            'ads_pixel' => ProductModule::t('product', 'Ads Pixel'),
            'ads_session' => ProductModule::t('product', 'Ads Session'),
            'status' => ProductModule::t('product', 'Status'),
            'views' => ProductModule::t('product', 'Views'),
            'language' => ProductModule::t('product', 'Language'),
            'created_at' => ProductModule::t('product', 'Created At'),
            'updated_at' => ProductModule::t('product', 'Updated At'),
            'created_by' => ProductModule::t('product', 'Created By'),
            'updated_by' => ProductModule::t('product', 'Updated By'),
        ];
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
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserUpdated()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImage()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }
}
