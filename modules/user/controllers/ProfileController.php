<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\Search;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\user\forms\UserForm;
use app\modules\user\models\User;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


class ProfileController extends Controller
{
    private $_user_id;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param string $id the ID of this controller.
     * @param Module $module the module that this controller belongs to.
     * @param array $config name-value pairs that will be used to initialize the object properties.
     */
    public function __construct($id, $module, $config = [])
    {
        $this->_user_id = Yii::$app->user->identity->id ?? null;
        parent::__construct($id, $module, $config);
    }

    /**
     * View User
     *
     * @param integer $id
     * @return string
     */
    public function actionView(): string
    {
        $model = $this->_findModel($this->_user_id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Update User
     *
     * @return string
     */
    public function actionEdit(): string
    {
        $user = $this->_findModel($this->_user_id);
        $model = new UserForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->edit($model);

            return $this->render('view', ['model' => $user]);
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }   

    /**
     *
     * @param integer $id
     * @return User
     * @throw NotFoundHttpException
     */
    protected function _findModel(int $id): User
    {
        if ($user = User::findOne($id)) {
            return $user;
        }

        throw new NotFoundHttpException('The requested page does not exist');
    }
}
