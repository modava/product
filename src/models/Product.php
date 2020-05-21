<?php

namespace modava\product\models;

use common\helpers\MyHelper;
use common\models\User;
use modava\product\models\table\ProductTable;
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
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'id' => Yii::t('product', 'ID'),
            'product_code' => Yii::t('product', 'Product Code'),
            'category_id' => Yii::t('product', 'Category ID'),
            'type_id' => Yii::t('product', 'Type ID'),
            'title' => Yii::t('product', 'Title'),
            'slug' => Yii::t('product', 'Slug'),
            'image' => Yii::t('product', 'Image'),
            'price' => Yii::t('product', 'Price'),
            'price_sale' => Yii::t('product', 'Price Sale'),
            'so_luong' => Yii::t('product', 'So Luong'),
            'description' => Yii::t('product', 'Description'),
            'content' => Yii::t('product', 'Content'),
            'position' => Yii::t('product', 'Position'),
            'ads_pixel' => Yii::t('product', 'Ads Pixel'),
            'ads_session' => Yii::t('product', 'Ads Session'),
            'status' => Yii::t('product', 'Status'),
            'views' => Yii::t('product', 'Views'),
            'language' => Yii::t('product', 'Language'),
            'created_at' => Yii::t('product', 'Created At'),
            'updated_at' => Yii::t('product', 'Updated At'),
            'created_by' => Yii::t('product', 'Created By'),
            'updated_by' => Yii::t('product', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    /**
     * Gets query for [[CreatedBy0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }
}
