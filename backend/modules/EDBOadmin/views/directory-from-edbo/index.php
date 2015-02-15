<?php
use yii\widgets\Pjax;
use kartik\tabs\TabsX;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
//use nirvana\showloading\ShowLoadingAsset;
//ShowLoadingAsset::register($this);
?>

<?php //yii\widgets\Pjax::begin() ?>
<div class="edbokoatuul1-form">


    <?php $form = ActiveForm::begin(); ?>


   <div>
   		<?= $form->field($model, 'id_directory')->dropDownList(
			ArrayHelper::map(app\modules\EDBOadmin\models\EdboDirectorytables::find()->asArray()->all(), 'id', 'name_directory'),
			['id'=>'name_directory']
			) 
		?>
		<?= $form->field($model, 'show_table')->checkbox() ?>
   </div>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app','Show'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="EDBOadmin-DirectoryFromEdbo-index">


    <?php
            
        echo TabsX::widget([
        'items' => [
            [
                'label' => "As request",
                'active' => true,
                'content' => $this->render('tabs_content_edborequest', [
                    'model' => $model,
                ]),
                                    
            ],

            [
                'label' => 'As table',
                'content' => $this->render('tabs_content_edbogrid', [
                    'model' => $model,
                ]),
                'headerOptions' => [],
                //'options' => ['id' => 'myveryownID'],
            ],
            
            /*[
                'label' => 'Dropdown',
                'items' => [
                     [
                         'label' => 'DropdownA',
                         'encode' => false,
                         'content' => 'DropdownA, Anim pariatur cliche...',
                     ],
                     [
                         'label' => 'DropdownB',
                         'encode' => false,
                         'content' => 'DropdownB, Anim pariatur cliche...',
                     ],
                ],
            ],*/
            ],
        ]);
    ?>

</div>

<?php// yii\widgets\Pjax::end() ?>