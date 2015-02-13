<?php
namespace app\modules\EDBOadmin\widgets;
//namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class EDBOStatusWidget extends Widget{
	public $interval_check = 30000;
	public $label = 'EDBO';
	
	public function init(){
		parent::init();
	}

	public function run(){
		$guid = uniqid();
		$url = Url::toRoute(['/EDBOadmin/default/edbo-status']);
		$data = 
		"
		 	<div  id=\"EDBO_status\" style=\"color:RGB(200,0,0);\" class=\"navbar-inverse navbar-brand\">
                $this->label
            </div>
		";	

	
		$js = 
		"
var _f_ = function () {
	$.ajax({
	 	url: '$url',
	  	cache: false,
	  	async: true,
	  	timeout: 15000,
	  	dataType: 'json',
	  	success: function(res){
	  		//console.log(res);
	  		if (res['status']) {
	    		$(\"#EDBO_status\").css('color', 'rgb(0,200,0)');
	  		} else {
				$(\"#EDBO_status\").css('color', 'rgb(0,200,0)');
	  		}
	  	},
	  	errrep:true,//отображение ошибок error если true
        error: function(jqXHR, exception) {
        	$(\"#EDBO_status\").css('color', 'rgb(200,0,0)');
        	//console.log('error');

            if (jqXHR.status === 0) {
                //alert('Not connect. Verify Network.');
            } else if (jqXHR.status == 404) {
                //alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                //alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                //alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                //alert('Time out error.');
            } else if (exception === 'abort') {
                //alert('Ajax request aborted.');
            } else {
                //alert('Uncaught Error.' + jqXHR.responseText);
            }

        }

	});
};
setTimeout(
	_f_
	, 500);

setInterval(
	_f_
	,
	$this->interval_check);
";
		
		$view = $this->getView();
		$view->registerJs($js);
        
		return $data;
	}


}
?>
