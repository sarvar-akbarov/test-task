<?php

namespace app\modules\post\controllers;

use Yii;
use app\modules\post\models\Search;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\post\forms\PostForm;
use app\modules\post\models\Post;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete'],
                        // so'rab olish kerak nimaga unaqa bo'ldi? 
                        'roles' => ['updatePost', 'manageArticles'],
                        'roleParams' => function() {
                            return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'publish'],
                        'roles' => ['manageArticles'],
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
     * Create Post
     *
     */
    public function actionCreate()
    {
        $model = new PostForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $post = Post::create($model);
            return $this->redirect(['view', 'id' => $post->id]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * View Post
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
     * Update Post
     *
     * @param integer $id
     */
    public function actionUpdate(int $id)
    {

        $post = $this->_findModel($id);

        $model = new PostForm($post);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $post->edit($model);
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }   

    /**
     * Delete Post
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
     * @return Post
     * @throw NotFoundHttpException
     */
    protected function _findModel(int $id): Post
    {
        if ($post = Post::findOne($id)) {
            return $post;
        }

        throw new NotFoundHttpException('The requested page does not exist');
    }
}
