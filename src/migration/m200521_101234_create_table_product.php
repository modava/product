<?php

use yii\db\Migration;

/**
 * Class m200521_103234_create_table_product
 */
class m200521_101234_create_table_product extends Migration
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

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'product_code' => $this->string(25)->null(),
            'category_id' => $this->integer(11)->notNull(),
            'type_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255)->null(),
            'price' => $this->string(255)->null(),
            'price_sale' => $this->string(255)->null(),
            'so_luong' => $this->string(255)->null(),
            'description' => $this->text()->null(),
            'content' => $this->text()->null(),
            'product_tech' => $this->json()->null(),
            'position' => $this->integer(11)->null(),
            'ads_pixel' => $this->text()->null(),
            'ads_session' => $this->text()->null(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'views' => $this->bigInteger(20)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'created_by' => $this->integer(11)->null(),
            'updated_by' => $this->integer(11)->null(),
        ], $tableOptions);

        $this->createIndex('index-slug', 'product', 'slug');
        $this->addColumn('product', 'language', "ENUM('vi', 'en', 'jp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi' COMMENT 'Language for yii2' AFTER `views`");
        $this->createIndex('index-language', 'product', 'language');
        $this->addForeignKey("fk_product_type", "product", "type_id", "product_type", "id", "RESTRICT", "CASCADE");
        $this->addForeignKey("fk_product_category", "product", "category_id", "product_category", "id", "RESTRICT", "CASCADE");
        $this->addForeignKey('fk_product_created_by_user', 'product', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_product_updated_by_user', 'product', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
