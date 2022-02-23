<?php

use app\modules\user\forms\UserForm;
use app\modules\user\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Foydalanuvchilar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Foydalanuvchi qo\'shish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'image', 
                'format' => 'html',
                'contentOptions' => ['width' => '120px'],
                'value' => function(User $model){
                    return Html::img($model->getImage(),['width' => '100px']);
                }
            ],
            'username',
            [
                'label' => 'Role',
                'attribute' => '',
                'value' => function($model){
                    return $model->getRoleDescription();
                },
                'filter' => UserForm::getRoleList()
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->getStatus();
                },
                'filter' => UserForm::getStatusList()
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
