<?php

namespace backend\models\article;

use backend\models\category\Category;
use backend\models\ProductCategory;
use common\behaviors\TimestampBehavior;
use common\components\Status;
use Yii;
use common\models\User;
use backend\models\comment\Comment;
use yii\base\Event;
use yii\db\Exception;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $visible
 * @property int|null $active
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $owner_id
 *
 * @property User $owner
 * @property ArticleStatistic[] $articleStatistics
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    public $tags;
    public $listCategories;

    const EVENT_STATISTIC = 'statistic';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tags', 'owner_id', 'listCategories'], 'required'],
            [['owner_id', 'visible', 'active', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['description', 'string'],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     *
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->listCategories = $this->getCategories()->all();
        $this->tags = $this->getArticleTags()->all();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'owner_id' => 'Owner',
            'visible' => 'Visible',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'listCategories' => 'Category'
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $oldTags= array_column($this->articleTags, 'article_id');
            $tagsNew = array_diff($this->tags, $oldTags);
            $tagsRem = array_diff($oldTags, $this->tags);
            ArticleTag::deleteAll(['article_id' => $tagsRem]);


            foreach ($tagsNew as $name) {
                $tags = new ArticleTag([
                    'article_id' => $this->id,
                    'name' => $name
                ]);
                $tags->save();
            }

            $oldListCategory = array_column($this->listCategories, 'category_id');
            $categoryNew = array_diff($this->listCategories, $oldListCategory);
            $categoryRem = array_diff($oldListCategory, $this->listCategories);
            ArticleCategory::deleteAll(['category_id' => $categoryRem]);

            foreach ($categoryNew as $categoryId) {
                $productCategory = new ArticleCategory(['category_id' => $categoryId]);
                $productCategory->link('article', $this);
            }

            $transaction->commit();
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[ArticleStatistics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleStatistics()
    {
        return $this->hasMany(ArticleStatistic::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id'])
            ->andOnCondition(['active' => Status::YES, 'visible' => Status::YES]);
    }

    /**
     * Gets query for [[ArticleCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(ArticleCategory::class, ['article_id' => 'id'])
            ->inverseOf('article');
    }

    /**
     * @return bool
     */
    public function isAccess()
    {
        return $this->owner_id === Yii::$app->user->getId();
    }
}
