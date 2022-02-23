<?php

namespace app\modules\user\behaviours;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\modules\user\forms\UserForm;

class Role extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'assign',
            ActiveRecord::EVENT_BEFORE_DELETE => 'revoke',
            ActiveRecord::EVENT_AFTER_UPDATE => 'assign'
        ];
    }


    /**
     * assign current user givern the rule
     *
     * @param string $roleName
     * @return void
     */
    public function assign()
    {
        if ($this->owner->role != null) {
            $authManager = Yii::$app->getAuthManager();
            $authManager->revokeAll($this->owner->id);
            $role = $authManager->getRole($this->owner->role);
            $authManager->assign($role, $this->owner->id);
        }
    }

    /**
     * revoke all rules current user
     *
     * @param string $roleName
     * @return void
     */
    public function revoke()
    {
        $authManager = Yii::$app->getAuthManager();
        $authManager->revokeAll($this->owner->id);
    }

    /**
     * get User Role name
     *
     * @return string|null
     */
    public function getRoleName(): string|null
    {
        $roles = array_keys(Yii::$app->getAuthManager()->getAssignments($this->owner->id));
        return $roles[0] ?? null;
    }

    /**
     * get User Role name
     *
     * @return string|null
     */
    public function getRoleDescription(): string|null
    {
        return UserForm::getRoleList()[$this->owner->role] ?? null;
    }
}
