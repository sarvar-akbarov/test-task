<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_category}}`.
 */
class m220222_123555_create_post_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наимования"),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_category}}');
    }
}
