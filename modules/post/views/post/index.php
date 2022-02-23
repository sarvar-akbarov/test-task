<?php

use app\modules\post\forms\PostForm;
use app\modules\post\models\Post;
use app\modules\user\forms\UserForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add new One', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'preview_img', 
                'format' => 'html',
                'contentOptions' => ['width' => '120px'],
                'value' => function(Post $model){
                    return Html::img($model->getImage(),['width' => '100px']);
                }
            ],
            'title',
            [
                'attribute' => 'category_id',
                'value' => function($model){
                    return $model->categoryName;
                },
                'filter' => PostForm::getCategoryList()
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->getStatus();
                },
                'filter' => PostForm::getStatusList()
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
