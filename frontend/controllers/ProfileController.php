<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use \yii\web\Controller;
use Yii;
use common\models\User;

class ProfileController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Yii::$app->user->identity;

        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;

        $model->scenario = User::SCENARIO_USER;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect('/');
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);

        return $this->render('view', [
           'user' => $user
        ]);
    }
}