<?php

namespace app\modules\post\models;

use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;

/**
 * Catgeory class
 */
class Category extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return "{{%post_category}}";
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'trim'],
            [['name'], 'string', 'min' => 2, 'max' => 255],
            [['name'], 'required'],
        ];
    }
}
