<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220222_123524_create_user_table extends Migration
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

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->comment("Имя пользователя"),
            'password_hash' => $this->string(255)->comment("Парол"),
            'auth_key' => $this->string(255)->comment("Ключ авторизации"),
            'created_at' => $this->integer()->comment("Дата регистрации"),
            'updated_at' => $this->integer()->comment("Дата последнего обновления"),
            'status' => $this->tinyInteger(2)->comment("Статус пользователя"),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
