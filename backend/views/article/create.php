<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\article\Article */
/** @var $articleTags array */

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'articleTags' => $articleTags
    ]) ?>

</div>
