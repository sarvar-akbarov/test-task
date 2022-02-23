<?php

use app\modules\user\forms\UserForm;
use PHPUnit\Util\Log\JSON;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\forms\UserForm */

$this->title = 'Yangi qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Foydalanuvchilar', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>
    <?=$this->title?>
</h1>
<hr>
<?php $form  = ActiveForm::begin() ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'role')->dropDownList(UserForm::getRoleList(), ['prompt' => 'Select']) ?>

    <?= $form->field($model, 'status')->dropDownList(UserForm::getStatusList(), ['prompt' => 'Select']) ?>

    <?=Html::submitButton('Saqlash', ['class' => 'btn btn-success'])?>

<?php ActiveForm::end() ?>