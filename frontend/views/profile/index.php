<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

?>
<div class="user-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            'role',
        ],
    ]) ?>

</div>
<table class="table">
    <thead>
    <tr>
        <th><?=Yii::t('app', 'Article')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model->articles as $article):?>
        <tr>
            <td><?=Html::a($article->title, ['/article/view', 'id' => $article->id], [])?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

