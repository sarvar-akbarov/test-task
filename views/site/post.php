<?php

/** @var yii\web\View $this */
/** @var object $post */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = $post->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title)?></h1>

    <p>
        <?=Html::encode($post->short)?>
    </p>
    <p>
        <?=HtmlPurifier::process($post->content)?>
    </p>
    
    <hr>

    <p class="post-meta">
            Posted by 
            <a href="#!"><?=$post->author?></a>
            on <?= Yii::$app->formatter->asDate($post->updated_at, 'php: F d, Y') ?>
        </p>

</div>
