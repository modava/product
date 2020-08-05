<?php

namespace modava\product\models\table;

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
 */
class ProductImageTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_image';
    }

}
