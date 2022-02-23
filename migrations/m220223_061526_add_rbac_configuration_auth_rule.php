<?php

use app\modules\post\rbac\AuthorRule;
use yii\db\Migration;

/**
 * Class m220223_061526_add_rbac_configuration_auth_rule
 */
class m220223_061526_add_rbac_configuration_auth_rule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // from https://www.yiiframework.com/doc/guide/2.0/en/security-authorization

        // add the rule
        $rule = new AuthorRule();
        $auth->add($rule);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update Post';
        $auth->add($updatePost);

        // add the "updateOwnPost" permission and associate the rule with it.
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);
        
        $manageArticles = $auth->getPermission('manageArticles');
        // "updateOwnPost" will be used from "updatePost"
        $auth->addChild($manageArticles, $updateOwnPost);
        $auth->addChild($updateOwnPost, $updatePost);

        $author = $auth->getRole('user');
        // allow "author" to update their own posts
        $auth->addChild($author, $updateOwnPost);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $updatePost = $auth->getPermission('updatePost');
        $updateOwnPost = $auth->getPermission('updateOwnPost');
        $author = $auth->getRole('user');
        $auth->removeChild($author, $updateOwnPost);
        $auth->removeChild($updateOwnPost, $updatePost);
        $auth->remove('updatePost');
        $auth->remove('updateOwnPost');
        return true;
    }
}
