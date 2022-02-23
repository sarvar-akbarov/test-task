<?php

use app\modules\user\forms\UserForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\post\models\Catgeory */

$this->title = 'Update #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>
    <?= $this->title ?>
</h1>
<hr>
<?php $form  = ActiveForm::begin() ?>

<?= $form->field($model, 'name') ?>

<?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>