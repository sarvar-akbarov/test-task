<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%post_category}}`
 * - `{{%user}}`
 */
class m220222_123838_create_post_table extends Migration
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

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment("Загаловок"),
            'short' => $this->string(511)->comment("Краткое описание"),
            'content' => $this->text()->comment("Контент"),
            'preview_img' => $this->string(255)->comment("Изображения"),
            'status' => $this->tinyInteger(2)->comment("Статус"),
            'created_at' => $this->integer()->comment("Создано в"),
            'updated_at' => $this->integer()->comment("Дата последнего обновления"),
            'author_id' => $this->integer()->comment("Автор"),
            'category_id' => $this->integer()->comment("Категория"),
            'checked_by' => $this->integer()->comment("Проверено"),
        ], $tableOptions);

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-post-author_id}}',
            '{{%post}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-post-author_id}}',
            '{{%post}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-post-category_id}}',
            '{{%post}}',
            'category_id'
        );

        // add foreign key for table `{{%post_category}}`
        $this->addForeignKey(
            '{{%fk-post-category_id}}',
            '{{%post}}',
            'category_id',
            '{{%post_category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `checked_by`
        $this->createIndex(
            '{{%idx-post-checked_by}}',
            '{{%post}}',
            'checked_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-post-checked_by}}',
            '{{%post}}',
            'checked_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-post-author_id}}',
            '{{%post}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-post-author_id}}',
            '{{%post}}'
        );

        // drops foreign key for table `{{%post_category}}`
        $this->dropForeignKey(
            '{{%fk-post-category_id}}',
            '{{%post}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-post-category_id}}',
            '{{%post}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-post-checked_by}}',
            '{{%post}}'
        );

        // drops index for column `checked_by`
        $this->dropIndex(
            '{{%idx-post-checked_by}}',
            '{{%post}}'
        );

        $this->dropTable('{{%post}}');
    }
}
