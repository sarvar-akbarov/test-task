<?php

namespace app\models;

use app\modules\post\forms\PostForm;
use Yii;

class Posts
{
    const PER_PAGE = 1;

    /**
     * get post list
     *
     * @param integer $page
     * @param integer|null|null $per_page
     * @return array
     */
    public static function getList(int $page = 0, int|null $per_page = null): array
    {
        if ($per_page === null) {
            $per_page = self::PER_PAGE;
        }

        $page = intval($page);

        $from = $page * $per_page;

        $sql = "SELECT 
                post.id, post.title, post.short,post.preview_img, post.author_id,post.category_id,post.updated_at,
                user.username as author,
                post_category.name as category
            FROM post 
                LEFT JOIN user ON post.author_id = user.id
                LEFT JOIN post_category ON post.category_id = post_category.id
            WHERE post.status=" . PostForm::STATUS_ACTIVE . " 
            ORDER BY post.updated_at DESC
            LIMIT $from, $per_page;
        ";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * get One By Id
     *
     * @param integer $id
     * @return object
     */
    public static function getOne(int $id): object
    {
        $id = intval($id);

        $sql = "SELECT 
                post.title, post.short,post.preview_img, post.author_id,post.category_id,post.content,post.updated_at,
                user.username as author,
                post_category.name as category
            FROM post 
                LEFT JOIN user ON post.author_id = user.id
                LEFT JOIN post_category ON post.category_id = post_category.id
            WHERE post.id=:id;
        ";

        return (object)Yii::$app->db->createCommand($sql)->bindParam(':id', $id)->queryOne();
    }
}
