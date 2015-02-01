<?php

namespace app\modules\EDBOtest\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {


    	if (!Yii::$app->edbo->EDBOGuides->status)
    		return false;

        return $this->render('index');
    }
}
