<?php

namespace backend\models\article\frontend;

use backend\models\article\Article as BaseArticle;
use common\components\Status;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Article extends BaseArticle
{
    public $userName;

    const TYPE_MY_POST = 1;
    const TYPE_ALL_POST = 2;
    const TYPE_POPULAR_POSY = 3;
    const TYPE_NO_ANSWER_POST = 4;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'visible', 'active', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'userName'], 'safe'],
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

    public function getArticleItems($params = [], $visible = Status::YES, $pageSize = 15)
    {
        $query = Article::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        $query->andFilterWhere(['visible' => $visible]);

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getListPost(): array
    {
        return [
            self::TYPE_MY_POST => \Yii::t('app', 'My post'),
            self::TYPE_ALL_POST => \Yii::t('app', 'All post'),
            self::TYPE_POPULAR_POSY => \Yii::t('app', 'Popular post'),
            self::TYPE_NO_ANSWER_POST => \Yii::t('app', 'No answer')
        ];
    }
}
