<?php

use app\modules\user\forms\UserForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\forms\UserForm */

$this->title = 'Tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Foydalanuvchilar', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>
    <?= $this->title ?>
</h1>
<hr>
<?php $form  = ActiveForm::begin() ?>
<div class="row">
    <div class="col-md-4">
        <div id="image">
            <?= Html::img($model->getImage(), ['width' => '300px', 'id' => 'output']) ?>
        </div>
        <br>
        <?= $form->field($model, 'image')->fileInput()->label(false) ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'username') ?>

        <?= $form->field($model, 'password') ?>

        <?= $form->field($model, 'role')->dropDownList(UserForm::getRoleList(), ['prompt' => 'Select']) ?>

        <?= $form->field($model, 'status')->dropDownList(UserForm::getStatusList(), ['prompt' => 'Tanlang']) ?>

        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>