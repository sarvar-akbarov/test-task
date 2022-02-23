<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ProfileForm extends Model
{
    const SCENARIO_CREATE = 'sc_creete';

    public $username;
    public $password;
    public $image;

    private $_user;

    public function __construct(User $user = null, $config = [])
    {
        parent::__construct($config);

        if ($user != null) {
            $this->username = $user->username;
            $this->image = $user->image;
        }else{
            $this->scenario = self::SCENARIO_CREATE;
        }

        $this->_user = $user;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['username', 'password', 'image', 'status', 'role'];
        return $scenarios;
    }


    public function rules()
    {
        return [
            [['username'], 'required'],
            [['password'], 'required', 'on' => self::SCENARIO_CREATE],

            [['username', 'password'], 'trim'],
            [['username', 'password'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => Yii::$app->params['minLengthUserPassword']],
            ['image', 'image', 'extensions' => ['png', 'jpg', 'jpeg'], 'mimeTypes' => ['image/jpeg', 'image/png']]
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        $this->image = UploadedFile::getInstance($this, 'image');
    }

    public function getImage(): string
    {
        return $this->_user->getImage();
    }
}
