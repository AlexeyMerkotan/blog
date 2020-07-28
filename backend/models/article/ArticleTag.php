<?php

namespace backend\models\article;

use common\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "article_tag".
 *
 * @property int $id
 * @property int|null $article_id
 * @property string|null $name
 *
 * @property Article $article
 */
class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * Get all tags
     *
     * @return array
     */
    public static function getAll()
    {
        return self::find()->select(['name'])->orderBy(['name' => 'SORT_ASC'])->indexBy('id')->column();
    }
}
