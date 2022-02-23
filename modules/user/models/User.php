<?php

namespace app\modules\user\models;

use app\modules\user\behaviours\ImageUpload;
use app\modules\user\behaviours\Role;
use Yii;
use app\modules\user\forms\UserForm;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * User class
 */
class User extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return "{{%user}}";
    }

    public function rules()
    {
        return [

        ];
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'uploadImageBehaviour' => [
                'class' => ImageUpload::class,
                'path' => 'user',
                'attribute' => 'image'
            ],
            'roleBehaviour' => [
                'class' => Role::class,
            ]
        ];
    }

    /**
     * Hash password and set 
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password)
    {
        if ($password)
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * generate Auth key
     * @return void
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Create User
     *
     * @param UserForm $user
     * @return self
     */
    public static function create(UserForm $user): self
    {
        $model = new self;
        $model->username = $user->username;
        $model->setPassword($user->password);
        $model->email = $user->email;
        $model->status = $user->status;
        $model->role = $user->role;
        $model->setImage($user->image);
        $model->generateAuthKey();

        $model->save(false);
        return $model;
    }

    /**
     * Create User
     *
     * @param UserForm $user
     * @return void
     */
    public function edit(UserForm $user): void
    {
        $this->username = $user->username;
        $this->setPassword($user->password);
        $this->email = $user->email;
        $this->status = $user->status ?? null;
        $this->role = $user->role ?? null;
        $this->setImage($user->image);

        $this->save(false);
    }

    public function setImage(UploadedFile $image = null)
    {
        if ($image != null) {
            $this->image = $image;
        }
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getStatus(): string|null
    {
        return UserForm::getStatusList()[$this->status] ?? null;
    }

    /**
     * get User Image
     *
     * @return string
     */
    public function getImage(): string
    {
        if (!$this->isNewRecord && $this->image && file_exists($image = Yii::getAlias('@uploads/user/') . $this->id . '/' . $this->image)) {
            return "/uploads/user/" . $this->id . '/' . $this->image;
        }

        return  '/uploads/user/no-img.png';
    }
}
