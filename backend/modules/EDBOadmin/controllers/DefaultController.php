<?php

namespace app\modules\EDBOadmin\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {

    	//if (!Yii::$app->edbo->EDBOGuides->status)
    	//	return \yii\helpers\Html::encode('EDBO out of service');

        return $this->render('index');
    }

    public function actionEdboStatus()
    {
    	if (\Yii::$app->edbo->EDBOGuides->GlobaliInfoGet())
    		$res['status'] = true;
    	else
    		$res['status'] = false;

        $request = Yii::$app->request;

        if ($request->isAjax)
    	   Yii::$app->getResponse()->format = yii\web\Response::FORMAT_JSON;

		return $res;
    }
}
