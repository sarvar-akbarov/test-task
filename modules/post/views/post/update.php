<?php

use app\assets\CkeditorAsset;
use app\modules\post\forms\PostForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\post\forms\PostForm */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;

mihaildev\elfinder\Assets::noConflict($this);
CkeditorAsset::register($this);
?>

<h1>
    <?= $this->title ?>
</h1>
<hr>

<?php $form  = ActiveForm::begin(['id' => 'postform']) ?>


<?= $form->field($model, 'preview_img')->fileInput()->label(false) ?>

<?= $form->field($model, 'title') ?>

<?= $form->field($model, 'short')->textarea(['rows' => 3]) ?>

<?= $form->field($model, 'content')->textarea(['rows' => 10]) ?>

<?= $form->field($model, 'category_id')->dropDownList(PostForm::getCategoryList(), ['prompt' => 'Select']) ?>

<?= $form->field($model, 'status')->dropDownList(PostForm::getStatusList(), ['prompt' => 'Select', 'disabled' => !\Yii::$app->user->can('manageArticles')]) ?>


<?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end() ?>

<?php $this->registerJs(<<<JS
    CKEDITOR.replace('postform-content', {
        height: 500,
        removeButtons: 'PasteFromWord',
        filebrowserBrowseUrl: '/elfinder/manager',
        filebrowserUploadUrl: '/elfinder/manager'
    });

    $('#postform').on('beforeValidate', function (event, messages, deferreds) {
        for(var instanceName in CKEDITOR.instances) { 
            CKEDITOR.instances[instanceName].updateElement();
        }
        return true;
    });

JS
);
?>