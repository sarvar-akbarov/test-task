<?php

use app\modules\user\forms\UserForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\forms\UserForm */

$this->title = 'Tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Shahsiy sahifa', 'url' => 'view'];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>
    <?= $this->title ?>
</h1>
<hr>
<?php $form  = ActiveForm::begin() ?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <div id="image">
            <?=Html::img($model->getImage(),['width' => '200px'])?>
        </div>
        <br>
        <br>
        <?= $form->field($model, 'image')->fileInput()->label(false) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->label('New password') ?>
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>