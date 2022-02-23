<?php

use app\modules\user\models\User;
use yii\db\Migration;

/**
 * Class m220222_153550_configure_rbac
 */
class m220222_153550_configure_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \Yii::$app->runAction('migrate', ['migrationPath' => '@yii/rbac/migrations/']);
        $auth = Yii::$app->authManager;

        // source https://yii2-cookbook-test.readthedocs.io/security-rbac/
        $manageArticles = $auth->createPermission('manageArticles');
        $manageArticles->description = 'Manage articles';
        $auth->add($manageArticles);

        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);

        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);
        $auth->addChild($moderator, $user);
        $auth->addChild($moderator, $manageArticles);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $manageUsers);
        
        // create user that has admin rights

        $this->delete('{{%user}}', ['id' => 1000]);

        $this->insert('{{%user}}', [
            'id' => 1000,
            'username' => 'admin',
            'password_hash' => \Yii::$app->security->generatePasswordHash('admin'),
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'created_at' => $time = time(),
            'updated_at' => $time,
            'status' => 10
        ]);

        $auth->assign($admin, User::findOne(1000)->id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->authManager->removeAll();
    }
}
