<?php

namespace backend\models\article\frontend;

use backend\models\article\Article as BaseArticle;
use common\components\Status;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Article extends BaseArticle
{
    public $userName;
    public $tags;
    public $type;

    const TYPE_MY_POST = 2;
    const TYPE_ALL_POST = 1;
    const TYPE_POPULAR_POSY = 3;
    const TYPE_NO_ANSWER_POST = 4;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'visible', 'active', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'userName', 'tags', 'type'], 'safe'],
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
        $this->load($params);

        switch ($this->type) {
            case self::TYPE_MY_POST:
                $query = $this->getOwnerPost();
                break;
            case self::TYPE_POPULAR_POSY:
                $query = $this->getPopularPost();
                break;
            case self::TYPE_NO_ANSWER_POST:
                $query = $this->getAnswerPost();
                break;
            default:
                $query = Article::find();
        }

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

        $query->andFilterWhere([
            '{{%article_tag}}.id' => $this->tags,
        ])->joinWith('articleTags');

        $query->andFilterWhere(['{{%article}}.visible' => $visible]);

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnerPost()
    {
        return Article::find()->where(['owner_id' => \Yii::$app->user->getId()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerPost()
    {
        return Article::find()->innerJoin('{{%comment}}', '{{%comment}}.article_id = {{%article}}.id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPopularPost()
    {
        return Article::find()
            ->innerJoin('{{%article_statistic}}', '{{%article_statistic}}.article_id = {{%article}}.id')
            ->groupBy('{{%article_statistic}}.article_id')
            ->orderBy(['Count({{%article_statistic}}.article_id)' => SORT_DESC]);
    }
}
