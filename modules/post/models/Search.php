<?php

namespace app\modules\post\models;

use app\modules\post\models\Post;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Search extends Post
{

    public $author;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'category_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['author', 'category']);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'post.status' => $this->status,
            'post.category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'user.username', $this->author]);

        return $dataProvider;
    }
}
