<?php

namespace modava\product\models;

use common\models\User;
use modava\product\ProductModule;
use Yii;
use modava\product\models\table\ProductImageTable;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_image".
 *
 * @property int $id
 * @property int $product_id
 * @property string $image_url
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property Product $product
 * @property User $updatedBy
 */
class ProductImage extends ProductImageTable
{
    public $toastr_key = 'product-image';

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'preserveNonEmptyValues' => true,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'image_url'], 'required'],
            [['product_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['image_url'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => ProductModule::t('product', 'ID'),
            'product_id' => ProductModule::t('product', 'Product ID'),
            'image_url' => ProductModule::t('product', 'Image Url'),
            'status' => ProductModule::t('product', 'Status'),
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
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
