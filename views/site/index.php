<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>

<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <?php if (count($posts) > 0) : ?>
            <div class="col-md-10 col-lg-8 col-xl-7">
                <!-- Post preview-->
                <?= $this->render('_posts', ['posts' => $posts]) ?>
                <!-- Pager-->
                <div id="more" data-value="1">

                </div>
                <div class="d-flex justify-content-end mb-4">
                    <a class="btn btn-primary text-uppercase more" href="/site/index?page=2">Older Posts →</a>
                </div>
            </div>
        <?php else : ?>
            <p class="alert alert-warning"> There is not any post yet.</p>

        <?php endif; ?>

    </div>
</div>


<?= $this->registerJS(
    <<<JS
    $('.more').on('click', function(event){
        event.preventDefault();
        let pager = $('#more');
        let nextPage = pager.attr('data-value');
        $.get('/site/index?page=' + nextPage, function(success){
            if(success.result){
                document.getElementById('more').insertAdjacentHTML('beforebegin', success.content);
                pager.attr('data-value', parseInt(nextPage) + 1);
            }else{
                content = "<p class='alert alert-warning'> No more posts </p>";
                document.getElementById('more').insertAdjacentHTML('beforebegin', content);
            }
        })
    })
JS
)
?>