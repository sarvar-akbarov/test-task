<?php

use app\modules\user\models\User;
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

<hr>
<div class="row">
    <div class="col-md-3"><?= Html::img($model->getImage(), ['width' => '200px']) ?></div>
    <div class="col-md-9">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [

                'username',
                'email',
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
        <p>
            <?= Html::a('Edit', ['edit'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>