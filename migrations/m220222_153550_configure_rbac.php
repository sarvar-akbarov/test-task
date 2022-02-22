<?php

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

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);
        $auth->addChild($moderator, $manageArticles);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $manageUsers);
        
        // create user that has admin rights
        $user = new \app\models\User([
            'username' => 'admin',
            'password_hash' => \Yii::$app->security->generatePasswordHash('admin'),
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'created_at' => $time = time(),
            'updated_at' => $time,
            'status' => 10
        ]);

        $user->save(false);

        $auth->assign($admin, $user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->authManager->removeAll();
    }
}
