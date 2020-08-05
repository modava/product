<?php

use yii\db\Migration;

/**
 * Class m200521_090122_create_table_product_type
 */
class m200521_090122_create_table_product_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255)->null(),
            'description' => $this->string()->null(),
            'position' => $this->integer(11)->null(),
            'ads_pixel' => $this->text()->null(),
            'ads_session' => $this->text()->null(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'created_by' => $this->integer(11)->null(),
            'updated_by' => $this->integer(11)->null(),
        ], $tableOptions);

        $this->addColumn('product_type', 'language', "ENUM('vi', 'en', 'jp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi' COMMENT 'Language' AFTER `status`");
        $this->createIndex('index-slug', 'product_type', 'slug');
        $this->createIndex('index-language', 'product_type', 'language');
        $this->addForeignKey('fk_product_created_by_type_user', 'product_type', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_product_updated_by_type_user', 'product_type', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_type}}');
    }
}
