<?php

//namespace backend\controllers;
namespace app\modules\EDBOadmin\controllers;

class TabsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTabsData() {
	    $html = $this->renderPartial('index');

	    return $html;//\yii\helpers\Json::encode($html);
    }

    public function actionUpdate($table)
    {
    	//sleep(5);
        return $this->renderPartial('update',$params = ['table' => $table ]);
    }

}
