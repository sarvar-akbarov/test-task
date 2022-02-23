<?php

use app\modules\post\models\Post;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\modules\user\forms\UserCreateForm */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => 'index'];
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
            'confirm' => 'Are you sure?',
            'method' => 'post',
        ],
    ])?>
</p>
<hr>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'preview_img', 
            'format' => 'html',
            'value' => function(Post $model){
                return Html::img($model->getImage(),['width' => '200px']);
            }
        ],
        'title',
        [
            'attribute' => 'category_id',
            'value' => function($model){
                return $model->categoryName;
            },
        ],
        
    ]
])?>

<p>
    <?=Html::encode($model->short)?>
</p>

<p>
    <?=HtmlPurifier::process($model->content)?>
</p>


<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'author.username',
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
