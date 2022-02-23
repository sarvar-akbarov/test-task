<?php foreach ($posts as $post) : ?>
    <div class="post-preview">
        <a href="<?= \yii\helpers\Url::to(['/site/post', 'id' => $post['id']]) ?>">
            <h2 class="post-title"><?= \yii\helpers\Html::encode($post['title']) ?></h2>
        </a>
        <p class="post-subtitle"><?= \yii\helpers\Html::encode($post['short']) ?></p>

        <p class="post-meta">
            Posted by 
            <a href="#!"><?=$post['author']?></a>
            on <?= Yii::$app->formatter->asDate($post['updated_at'], 'php: F d, Y') ?>
        </p>
    </div>
    <!-- Divider-->
    <hr class="my-4" />
<?php endforeach ?>