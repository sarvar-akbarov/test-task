<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\modules\user\forms\UserCreateForm */

$this->title = 'Foydalanuvchi';
$this->params['breadcrumbs'][] = ['label' => 'Foydalanuvchilar', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>
    <?=$this->title?>
</h1>
<p>
    <?=Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-success'])?>
    <?=Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Rostdan ham ushbu foydalanuvchini o\'chirmoqchimisiz?',
            'method' => 'post',
        ],
    ])?>
</p>
<hr>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'image', 
            'format' => 'html',
            'value' => function(User $model){
                return Html::img($model->getImage(),['width' => '200px']);
            }
        ],
        'username',
        [
            'label' => 'Role',
            'value' => function($model){
                return $model->getRoleDescription();
            }
        ],
        'created_at:datetime',
        'updated_at:datetime',
        [
            'attribute' => 'status', 
            'value' => function($model){
                return $model->getStatus();
            }
        ]
    ]
])?>

