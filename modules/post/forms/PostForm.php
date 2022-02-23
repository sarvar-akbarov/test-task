<?php

namespace app\modules\post\forms;

use app\modules\post\models\Category;
use app\modules\post\models\Post;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class PostForm extends Model
{
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;

    public $title;
    public $short;
    public $content;
    public $status;
    public $preview_img;
    public $category_id;

    private $_post;

    public function __construct(Post $post = null, $config = [])
    {
        if($post != null) {
            $this->title = $post->title;
            $this->content = $post->content;
            $this->short = $post->short;
            $this->status = $post->status;
            $this->category_id = $post->category_id;
        }

        $this->_post = $post;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['title', 'short'], 'trim'],
            [['title'], 'string', 'max' => 255],
            [['short'], 'string', 'max' => 511],

            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
            [['status'], 'default', 'value' => self::STATUS_INACTIVE],

            [['category_id'], 'integer'],
            [['category_id'], 'required'],
            ['category_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],    

            ['preview_img', 'image', 'extensions' => ['png', 'jpg', 'jpeg'], 'mimeTypes' => ['preview_img/jpeg', 'preview_img/png']]
        ];
    }

    /**
     * @return array
     */
    public static function getStatusList():array
    {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_INACTIVE => 'Неактивный',
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        $this->preview_img = UploadedFile::getInstance($this, 'preview_img');
    }

    /**
     * @return array
     */
    public static function getCategoryList():array
    {
        return ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name');
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->_post->getImage();
    }
}