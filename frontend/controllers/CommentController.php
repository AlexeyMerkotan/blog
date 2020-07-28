<?php

namespace frontend\controllers;

use backend\models\comment\Comment;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
{
    /**
     * @param $articleId
     * @return string|\yii\web\Response
     */
    public function actionCreate($articleId)
    {
        $model = new Comment(['article_id' => $articleId]);

        if (!Yii::$app->user->isGuest) {
            $model->owner_id = Yii::$app->user->getId();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'The comment will be added after approval by the admin');

            return $this->redirect(Yii::$app->request->referrer);
        }

        return  $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/');
        }

        return  $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return Comment|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
