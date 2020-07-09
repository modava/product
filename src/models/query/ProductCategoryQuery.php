<?php

namespace modava\product\models\query;

use modava\product\models\ProductCategory;

/**
 * This is the ActiveQuery class for [[ProductCategory]].
 *
 * @see ProductCategoryQuery
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

    public function findByLanguage()
    {
        $this->andWhere([ProductCategory::tableName() . '.language' => \Yii::$app->language]);
    }
}
