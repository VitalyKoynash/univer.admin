<?php
namespace app\modules\EDBOadmin\widgets;
//namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class UpdateEDBOTablesWidget extends Widget{
	public $table;
	
	public function init(){
		parent::init();
		/*
		if($this->message===null){
			$this->message= 'Welcome User';
		}else{
			$this->message= 'Welcome '.$this->message;
		}
		*/
	}
	/*
	http://rmcreative.ru/blog/post/yii2-izmenenija-v-rabote-s-url
	use yii\helpers\Url;
 
echo Url::to(''); // текущий URL
 
echo Url::toRoute(['view', 'id' => 'contact']); // тот же контроллер, другой экшн
echo Url::toRoute('post/index'); // тот же модуль, другие контроллер и экшн
echo Url::toRoute('/site/index'); // абсолютный роут вне зависимости от текущего контроллера
echo Url::toRoute('hi-tech'); // URL для экшна в с регистрозависимым именем `actionHiTech` текущего контроллера
echo Url::toRoute(['/date-time/fast-forward', 'id' => 105]); // URL для регистрозависимых экшна и контроллера `DateTimeController::actionFastForward`
 
echo Url::to('@web'); // получаем URL из алиаса
 
echo Url::canonical(); // получаем canonical URL для текущей страницы
echo Url::home(); // получаем домашний URL
 
Url::remember(); // сохраняем URL для последующего использования
Url::previous(); // получаем ранее сохранённый URL
	*/
	//update $this->table
//['data-pjax' => '#upd_'.$this->table]   ,['data-pjax' => '#formsection'] 
	public function run(){
		$t = time();
		$guid = uniqid();
		$url = Url::toRoute(['tabs/update', 'table'=>$this->table]);
		$data = 
		"<div id=\"pjax_table_$guid\">
			<span>Refresh  $this->table $t &nbsp;</span>". Html::a(
			"<span class=\"glyphicon glyphicon-refresh \"></span>",
			$url,
			['data-pjax' => "#pjax_table_$guid",]
				).
		"</div>";	

	
		$js = "$(\"#pjax_table_$guid\").pjax('a[data-pjax]', {'push':false,'replace':false,'timeout':100000,'scrollTo':false});"; //, "#pjax-table" [data-pjax]
		$js_events=
"
$('#pjax_table_$guid').on('pjax:beforeSend', function() {
	$('#pjax_table_$guid').showLoading();
})
$('#pjax_table_$guid').on('pjax:complete', function() {
  	$('#pjax_table_$guid').hideLoading();
})
";
		$view = $this->getView();
		$view->registerJs($js.$js_events);
        
		return $data;
	}


}
?>
