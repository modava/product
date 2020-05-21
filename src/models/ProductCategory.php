<?php

namespace modava\product\models;

use common\helpers\MyHelper;
use common\models\User;
use modava\product\models\table\ProductCategoryTable;
use Yii;
use modava\product\ProductModule;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;


class ProductCategory extends ProductCategoryTable
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
            [['title'], 'required'],
            [['parent_id', 'position', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['ads_pixel', 'ads_session', 'language'], 'string'],
            [['title', 'slug', 'image', 'description'], 'string', 'max' => 255],
            ['language', 'in', 'range' => ['vi', 'en', 'jp'], 'strict' => false],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => ProductModule::t('product', 'ID'),
            'title' => ProductModule::t('product', 'Title'),
            'slug' => ProductModule::t('product', 'Slug'),
            'parent_id' => ProductModule::t('product', 'Parent ID'),
            'image' => ProductModule::t('product', 'Image'),
            'description' => ProductModule::t('product', 'Description'),
            'position' => ProductModule::t('product', 'Position'),
            'ads_pixel' => ProductModule::t('product', 'Ads Pixel'),
            'ads_session' => ProductModule::t('product', 'Ads Session'),
            'status' => ProductModule::t('product', 'Status'),
            'language' => ProductModule::t('product', 'Language'),
            'created_at' => ProductModule::t('product', 'Created At'),
            'updated_at' => ProductModule::t('product', 'Updated At'),
            'created_by' => ProductModule::t('product', 'Created By'),
            'updated_by' => ProductModule::t('product', 'Updated By'),
        ];
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
}
