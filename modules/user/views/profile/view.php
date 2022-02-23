<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\user\forms\UserCreateForm */

$this->title = 'Foydalanuvchi sahifasi';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>
    <?= $this->title ?>
</h1>
<p>
    <?= Html::a('Update', ['edit'], ['class' => 'btn btn-success']) ?>
</p>
<hr>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'username',
        'created_at:datetime',
        'updated_at:datetime',
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return $model->getStatus();
            }
        ]
    ]
]) ?>