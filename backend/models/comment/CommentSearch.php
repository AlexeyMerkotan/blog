<?php

namespace backend\models\comment;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\comment\Comment;

/**
 * CommentSearch represents the model behind the search form of `backend\models\comment\Comment`.
 */
class CommentSearch extends Comment
{
    public $userName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'article_id', 'parent_id', 'owner', 'visible', 'active', 'created_at', 'updated_at'], 'integer'],
            [['description', 'userName'], 'safe'],
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
        $query = Comment::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'article_id' => $this->article_id,
            'parent_id' => $this->parent_id,
            'owner_id' => $this->owner,
            'visible' => $this->visible,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'owner.username', $this->userName])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
