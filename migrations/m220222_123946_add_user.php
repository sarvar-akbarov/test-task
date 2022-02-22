<?php

use yii\db\Migration;

/**
 * Class m220222_123946_add_user
 */
class m220222_123946_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => \Yii::$app->security->generatePasswordHash('admin'),
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'created_at' => $time = time(),
            'updated_at' => $time,
            'status' => 10
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220222_123946_add_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220222_123946_add_user cannot be reverted.\n";

        return false;
    }
    */
}
