<?php

namespace app\modules\EDBOadmin\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {


    	if (!Yii::$app->edbo->EDBOGuides->status)
    		return \yii\helpers\Html::encode('EDBO out of service');

        return $this->render('index');
    }
}
