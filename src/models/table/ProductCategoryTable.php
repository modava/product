<?php

namespace modava\product\models\table;

use Yii;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int|null $parent_id
 * @property string|null $image
 * @property string|null $description
 * @property int|null $position
 * @property string|null $ads_pixel
 * @property string|null $ads_session
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class ProductCategoryTable extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DISABLED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category';
    }
}
