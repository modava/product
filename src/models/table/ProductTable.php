<?php

namespace modava\product\models\table;

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
 * @property ProductCategory $category
 * @property User $createdBy
 * @property ProductType $type
 * @property User $createdBy0
 * @property ProductImage[] $productImages
 */
class ProductTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }
}
