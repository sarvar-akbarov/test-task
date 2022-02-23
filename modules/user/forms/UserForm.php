<?php

namespace app\modules\user\forms;

use Yii;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;

class UserForm extends ProfileForm
{
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;

    public $status;
    public $role;

    public function __construct(User $user = null, $config = [])
    {
        if($user != null) {
            $this->status = $user->status;
            $this->role = $user->getRoleName();
        }
        parent::__construct($user, $config);
    }

    public function rules()
    {
        // custom rules 
        $custom_rules = [
            [['status'], 'required'],
            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
            [['role'], 'required'],
            [['role'], 'in', 'range' => array_keys(self::getRoleList())]
        ];

        return array_merge(parent::rules(), $custom_rules);
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_INACTIVE => 'Неактивный',
        ];
    }

    /**
     * get user role list as array
     *
     * @return array
     */
    public static function getRoleList(): array
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

}