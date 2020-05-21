<?php

namespace modava\product\models\table;

use modava\product\models\query\ProductTypeQuery;
use Yii;

/**
 * This is the model class for table "product_type".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $image
 * @property string|null $description
 * @property int|null $position
 * @property string|null $ads_pixel
 * @property string|null $ads_session
 * @property int $status
 * @property string $language Language
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class ProductTypeTable extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DISABLED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_type';
    }

    public static function find()
    {
        return new ProductTypeQuery(get_called_class());
    }


}
