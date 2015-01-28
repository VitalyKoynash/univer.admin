<?php

namespace app\modules\EDBOtest\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {


    	\Yii::$app->edbo->info();

        return $this->render('index');
    }
}
