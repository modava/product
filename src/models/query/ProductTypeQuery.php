<?php

namespace modava\product\models\query;

use modava\product\models\ProductType;

/**
 * This is the ActiveQuery class for [[ProductCategory]].
 *
 * @see ProductCategoryQuery
 */
class ProductTypeQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([ProductType::tableName() . '.status' => ProductType::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([ProductType::tableName() . '.status' => ProductType::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }
    public function findByLanguage()
    {
        return $this->andWhere([ProductType::tableName() . '.language' => \Yii::$app->language])
            ->orWhere([ProductType::tableName() . '.language' => '']);
    }
}
