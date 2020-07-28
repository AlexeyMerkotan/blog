<?php

namespace backend\models\category;

use backend\models\article\Article;
use Yii;
use backend\models\article\ArticleCategory;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $name
 *
 * @property ArticleCategory[] $articleCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return  $this->hasMany(Article::class, ['id' => 'category_id'])
            ->viaTable('{{%article_category}}', ['category_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getListCategory()
    {
        return self::find()->all();
    }
}
