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

    public function actionEdboStatus()
    {

    	$res = array();
    	if (\Yii::$app->edbo->EDBOGuides->GlobaliInfoGet())
    		$res['status'] = true;
    	else
    		$res['status'] = false;
    	//if (!)
    	//	return \yii\helpers\Html::encode('EDBO out of service');
    	Yii::$app->getResponse()->format = yii\web\Response::FORMAT_JSON;

    	//\Yii::$app->response->format = 'json';
		return $res;
    	//return json_encode($res);
        //return \yii\helpers\Json::encode($res);;
    }
}
