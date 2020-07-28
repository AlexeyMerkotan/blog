<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Status;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\article\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'userName',
                'value' => function ($model) {
                    return $model->owner->username;
                },

            ],
            [
                'attribute' => 'visible',
                'filter' => Status::getStatuses(),
                'value' => function ($model) {
                    return Status::getName($model->visible);
                },
            ],
            [
                'attribute' => 'active',
                'filter' => Status::getStatuses(),
                'value' => function ($model) {
                    return Status::getName($model->active);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
