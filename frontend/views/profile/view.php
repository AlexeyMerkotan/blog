<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="user-view">
    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            'username',
            'email:email',
            'role',
        ],
    ]) ?>
</div>
<hr>
<table class="table">
    <thead>
    <tr>
        <th><?=Yii::t('app', 'Article')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($user->articles as $article):?>
        <tr>
            <td><?=Html::a($article->title, ['/article/view', 'id' => $article->id], [])?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

