<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    private function setPasswordHashOnCreate($model)
    {
        $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);
        return true;
    }

    private function setPasswordHashOnUpdate($model, $password_hash)
    {

        $new_password = Yii::$app->request->post('User')['password_hash'];

        if ($password_hash != $new_password) // user -  change pwd
            $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);
        return true;
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->status = User::STATUS_ACTIVE;
        //$model->generateAuthKey();

        if ($model->load(Yii::$app->request->post()) && $this->setPasswordHashOnCreate($model) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $password_hash = $model->password_hash;
        if ($model->load(Yii::$app->request->post()) && $this->setPasswordHashOnUpdate($model, $password_hash) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        if (Yii::$app->user->getId() == $id || $id == 1)
        {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You can not remove yourself or first admin!'));
            $this->redirect(['index']);//\Yii::$app->request->getReferrer()
            return;
        }
        //$auth = Yii::$app->authManager;
        //$auth->Role('admin');
        $manager = Yii::$app->authManager;

        $assignments = $manager->getAssignments($id); 
/*
         $var = print_r($assignments, true);

         Yii::$app->session->setFlash('error', $var);
            $this->redirect(['index']);//\Yii::$app->request->getReferrer()
            return;
*/
        foreach ($assignments as $idx=>$role) {
            try {
                $item = $manager->getRole($role->roleName);
                $item = $item ? : $manager->getPermission($role->roleName);
                $manager->revoke($item, $id);
            } catch (\Exception $exc) {
                $error[] = $exc->getMessage();

                Yii::$app->session->setFlash('error', $exc->getMessage());
                $this->redirect(['index']);//\Yii::$app->request->getReferrer()
                return;
            }
        }

        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('error', Yii::t('app', 'User has been deleted!'));
        //\Yii::trace($id);
        //\Yii::trace(Yii::$app->user->getId() );
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
