<?php

namespace app\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\post\models\Category;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
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
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find() 
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Category
     *
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
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
     */
    public function actionUpdate(int $id)
    {
        $model = $this->_findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
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
     * @return Category
     * @throw NotFoundHttpException
     */
    protected function _findModel(int $id): Category
    {
        if ($category = Category::findOne($id)) {
            return $category;
        }

        throw new NotFoundHttpException('The requested page does not exist');
    }
}
