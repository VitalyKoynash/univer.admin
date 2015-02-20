<?php
use yii\widgets\Pjax;
use kartik\tabs\TabsX;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use nirvana\showloading\ShowLoadingAsset;
ShowLoadingAsset::register($this);
?>

<?php //yii\widgets\Pjax::begin() ?>
<?php Pjax::begin([
        'enableReplaceState'=>false,
        'enablePushState'=>false,
        'id' => 'my-pjax'
        ]); ?>

<div class="edbokoatuul1-form">


    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>


   <div>
   		<?= $form->field($model, 'id_directory')->dropDownList(
			ArrayHelper::map(app\modules\EDBOadmin\models\EdboDirectorytables::find()->asArray()->all(), 'id', 'name_directory'),
			['id'=>'name_directory', 'onchange' => 'loadSettings(this)']
            ) 
		?>
		<?= $form->field($model, 'show_table')->checkbox() ?>
        <div id="derectory_settings">     
            <?php if ( !is_null($model->id_directory)): ?>  
                <?= $this->render('settings'); ?>
            <?php else: ?>   
            <?php endif;?>
        </div>
    </div>

    <?php
        use yii\helpers\Url;
        $url = Url::toRoute(['settings']);


        use yii\web\View;
        $this->registerJs("
        function loadSettings(self) {
        console.log(self);
        console.log(self.value);
        //return;

        //$(self).find('derectory_settings').showLoading();
                //$('w1').showLoading();
                
                $.ajax({
                    type: 'POST',
                    url: '$url',
                    data: {id_directory : self.value},
                    dataType: 'json',
                    timeout: 3000,
                    cache: false,
                    async: false,
                    // Выводим то что вернул PHP
                    success: function(res) {
                        //$(self).find('derectory_settings').hideLoading();
                        //var pjax_id = $(self).closest('.pjax-wraper').attr('id');
                        //$.pjax.reload('#' + pjax_id);
                        //console.log(self);
                        console.log(res);
                        $(\"#derectory_settings\").html(res['res']);
                                                                   
                    },
                    errrep:true,//отображение ошибок error если true
                    error: function(jqXHR, exception) {
                        //$(self).find('derectory_settings').hideLoading();
                        //$('w1').hideLoading();
                        if (jqXHR.status === 0) {
                            alert('Not connect. Verify Network.');
                        } else if (jqXHR.status == 404) {
                            alert('Requested page not found. [404]');
                        } else if (jqXHR.status == 500) {
                            alert('Internal Server Error [500].');
                        } else if (exception === 'parsererror') {
                            alert('Requested JSON parse failed.');
                        } else if (exception === 'timeout') {
                            alert('Time out error.');
                        } else if (exception === 'abort') {
                            alert('Ajax request aborted.');
                        } else {
                            alert('Uncaught Error.' + jqXHR.responseText);
                        }
                    }
                });
      }", View::POS_END);
    ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app','Show'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div>
    <?= Yii::$app->request->post('test', 'empty'); ?>
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

<?php yii\widgets\Pjax::end() ?>





