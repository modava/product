<?php

use yii\db\Migration;

/**
 * Class m201204_111258_add_alias_product
 */
class m201204_111258_add_alias_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns_product_category = Yii::$app->db->getTableSchema('product_category')->columns;
        if (is_array($columns_product_category) && !array_key_exists('alias', $columns_product_category)) {
            $this->addColumn('product_category', 'alias', $this->string(255)->null());
        }
        $columns_product = Yii::$app->db->getTableSchema('product')->columns;
        if (is_array($columns_product) && !array_key_exists('alias', $columns_product)) {
            $this->addColumn('product', 'alias', $this->string(255)->null());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201204_111258_add_alias_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201204_111258_add_alias_product cannot be reverted.\n";

        return false;
    }
    */
}
