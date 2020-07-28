<?php

namespace frontend\controllers;

use backend\models\article\Article;
use backend\models\article\ArticleStatistic;
use backend\models\comment\Comment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class ArticleController extends Controller
{
    private const ACTION = 'view';

    public function beforeAction($action)
    {
        if ($action->id === self::ACTION) {
            $articleId = Yii::$app->request->get('id');
            $articleStatistic = new ArticleStatistic([
                'article_id' => $articleId
            ]);
            $articleStatistic->save(false);
        }

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $comment = new Comment();

        return $this->render('view', [
            'model' => $model,
            'comment' => $comment
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Article();

        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'You need to login');

            return $this->redirect('/');
        }

        $model->owner_id = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/');
        }

        return $this->render('create', [
            'model' => $model,
            'articleTags' => [],
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

        if ($model->isAccess()) {
            $articleTags =  $model->articleTags;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('/');
            }

            return  $this->render('update', [
                'model' => $model,
                'articleTags' => $articleTags,
            ]);
        }
        Yii::$app->getSession()->setFlash('error', Yii::t('app', 'You dont have access'));

        return $this->redirect('/');
    }

    /**
     * @param $id
     * @return Article|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}