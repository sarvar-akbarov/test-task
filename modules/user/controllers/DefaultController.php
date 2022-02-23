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

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manageUsers'],
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

    public function actionIndex()
    {
        $searchModel = new Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Create User
     *
     * @return string
     */
    public function actionCreate(): string
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::create($model);
            return $this->render('view', ['model' => $user]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * View User
     *
     * @param integer $id
     * @return string
     */
    public function actionView(int $id): string
    {
        $model = $this->_findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Update User
     *
     * @param integer $id
     * @return string
     */
    public function actionUpdate(int $id): string
    {
        $user = $this->_findModel($id);
        $model = new UserForm($user);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->edit($model);

            return $this->render('view', ['model' => $user]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }   

    /**
     * Delete User
     *
     * @param integer $id
     * @return void
     */
    public function actionDelete(int $id)
    {
        $model = $this->_findModel($id);
        $model->delete();
        return $this->redirect(['index']);
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
