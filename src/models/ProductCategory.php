<?php

namespace modava\product\models;

use common\models\User;
use modava\product\models\table\ProductCategoryTable;
use Yii;
use modava\product\Product as ModuleProduct;


class ProductCategory extends ProductCategoryTable
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'created_at', 'updated_at'], 'required'],
            [['parent_id', 'position', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['ads_pixel', 'ads_session'], 'string'],
            [['title', 'slug', 'image', 'description'], 'string', 'max' => 255],
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
            'id' => ModuleProduct::t('product', 'ID'),
            'title' => ModuleProduct::t('product', 'Title'),
            'slug' => ModuleProduct::t('product', 'Slug'),
            'parent_id' => ModuleProduct::t('product', 'Parent ID'),
            'image' => ModuleProduct::t('product', 'Image'),
            'description' => ModuleProduct::t('product', 'Description'),
            'position' => ModuleProduct::t('product', 'Position'),
            'ads_pixel' => ModuleProduct::t('product', 'Ads Pixel'),
            'ads_session' => ModuleProduct::t('product', 'Ads Session'),
            'status' => ModuleProduct::t('product', 'Status'),
            'created_at' => ModuleProduct::t('product', 'Created At'),
            'updated_at' => ModuleProduct::t('product', 'Updated At'),
            'created_by' => ModuleProduct::t('product', 'Created By'),
            'updated_by' => ModuleProduct::t('product', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
