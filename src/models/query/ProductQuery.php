<?php

namespace modava\product\models\query;

use modava\product\models\Product;

/**
 * This is the ActiveQuery class for [[ProductCategory]].
 *
 * @see ProductCategoryQuery
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([Product::tableName() . '.status' => Product::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([Product::tableName() . '.status' => Product::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }
}
