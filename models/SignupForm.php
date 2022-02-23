<?php

namespace app\models;

use app\modules\user\forms\UserForm;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * SignupForm is the model behind the signup form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],

            [['username'], 'trim'],
            [['username'], 'string', 'max' => 255, 'min' => 3],
            ['username', 'unique', 'targetClass' => User::class],    
            
            [['email'], 'trim'],
            ['email', 'email'],
            [['email'], 'string', 'max' => 255, 'min' => 3],
            ['email', 'unique', 'targetClass' => User::class],  

            [['password'], 'trim'],
            [['password'], 'string', 'max' => 255, 'min' => Yii::$app->params['minLengthUserPassword']],
        ];
    }

    public function signup(): User|false
    {
        if(!$this->validate())
            return false;

        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->username);
        $user->generateAuthKey();
        // to do !verification
        $user->status = UserForm::STATUS_ACTIVE;
        $user->role = 'user';

        return $user->save() && $this->sendMail($user) ? $user : false;
    }


    private function sendMail($user):bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
    
}
