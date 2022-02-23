<?php

namespace app\modules\post\models;

use app\modules\user\behaviours\ImageUpload;
use Yii;
use app\modules\post\forms\PostForm;
use app\modules\user\models\User;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;

/**
 * Post class
 */
class Post extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return "{{%post}}";
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
            ],
            'uploadImageBehaviour' => [
                'class' => ImageUpload::class,
                'path' => 'post',
                'attribute' => 'preview_img'
            ]
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }


    /**
     * Create Post
     *
     * @param PostForm $post
     * @return self
     */
    public static function create(PostForm $post): self
    {
        $model = new self;
        $model->title = $post->title;
        $model->short = $post->short;
        $model->content = $post->content;
        $model->category_id = $post->category_id;
        $model->status = $post->status;
        $model->setImage($post->preview_img);
        $model->setAuthor();
        $model->save(false);
        return $model;
    }

    /**
     * Create Post
     *
     * @param PostForm $post
     * @return void
     */
    public function edit(PostForm $post): void
    {
        $this->title = $post->title;
        $this->short = $post->short;
        $this->content = $post->content;
        $this->category_id = $post->category_id;
        $this->status = $post->status ?? null;
        $this->setImage($post->preview_img);

        $this->save(false);
    }

    public function setImage(UploadedFile $preview_img = null)
    {
        if ($preview_img != null) {
            $this->preview_img = $preview_img;
        }
    }

    
    public function setAuthor()
    {
        $this->author_id = Yii::$app->user->identity->id;
    }

    /**
     *
     * @return string|null
     */
    public function getStatus(): string|null
    {
        return PostForm::getStatusList()[$this->status] ?? null;
    }

    /**
     * get Post Image
     *
     * @return string
     */
    public function getImage(): string
    {
        if (!$this->isNewRecord && $this->preview_img && file_exists($preview_img = Yii::getAlias('@uploads/post/') . $this->id . '/' . $this->preview_img)) {
            return "/uploads/post/" . $this->id . '/' . $this->preview_img;
        }

        return  '/uploads/post/no-img.png';
    }

    /**
     *
     * @return string|null
     */
    public function getCategoryName():string|null
    {
        return $this->category ? $this->category->name : null;
    }
}
