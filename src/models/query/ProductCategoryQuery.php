<?php

namespace modava\product\models\query;

use modava\product\models\ProductCategory;

/**
 * This is the ActiveQuery class for [[ArticleCategory]].
 *
 * @see ArticleCategory
 */
class ProductCategoryQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([ProductCategory::tableName() . '.status' => ProductCategory::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([ProductCategory::tableName() . '.status' => ProductCategory::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }
}
