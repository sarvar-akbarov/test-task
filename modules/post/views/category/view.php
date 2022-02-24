<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\modules\user\forms\UserCreateForm */

$this->title = 'Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => 'index'];
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

        'name',
       
    ]
])?>

