<?php

namespace app\modules\EDBOadmin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


//namespace backend\controllers;


use app\modules\EDBOadmin\models\DirectoryFromEDBO;

class DirectoryFromEdboController extends Controller
{
    public function actionIndex()
    {
        

        $model = new DirectoryFromEDBO ();

        $model->load(Yii::$app->request->post());

        if (!is_null($model->id_directory)) {
            \Yii::$app->session->set('DirectoryFromEdboController.id_directory',$model->id_directory);
        } else {
            $model->id_directory = \Yii::$app->session->get('DirectoryFromEdboController.id_directory');
        }

        //\Yii::trace ('$id_directory = ' . $model->id_directory . ' is null = ' . is_null($model->id_directory));
        
        $model->loadEDBO();
        
        return $this->render('index', array('model' => $model));
        
    }


    public function actionSettings()
    {
        $request = Yii::$app->request;

        if ($request->isAjax)
            Yii::$app->getResponse()->format = yii\web\Response::FORMAT_JSON;
        
        $res['res'] = $this->renderPartial('settings');
       
        return $res;
        
    }

}
