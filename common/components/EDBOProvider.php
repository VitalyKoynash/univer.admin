<?php

namespace common\components;

use yii\base\Component;
use yii\base\Event;
use common\components\EDBOSoapHelper;
use common\components\EDBOGuides;
/**
 * 
 *
 * @author Vitaly Koynash <vitaly.koynash@gmail.com>
 * @since 1.0
 */
class EDBOProvider extends Component
{
    public $applicationKey = '';
    public $clearPreviewSession = 1;
    public $hostEDBOGuides = "http://10.22.22.129:8080/EDBOGuides/EDBOGuides.asmx?WSDL";
    public $hostEDBOPerson = "http://10.22.22.129:8080/EDBOPerson/EDBOPerson.asmx?WSDL";

    private $_EDBOGuides = NULL;
    /*
    public function init(){
        parent::init();
        
    }*/

    public function info(){
        $info = 
        "<div>EDBO:</div>
        <div>applicationKey - $this->applicationKey</div>
        <div>hostEDBOGuides - $this->hostEDBOGuides</div>
        <div>hostEDBOPerson - $this->hostEDBOPerson</div>
        <p>". $this->EDBOGuides->info().'</p>';
        return $info;
    }


    public function getEDBOGuides()
    {

        if (is_null($this->_EDBOGuides))
            $this->_EDBOGuides = new EDBOGuides();
        return $this->_EDBOGuides;
    }
    //const RULE_NAME = 'route_rule';

    /**
     * @inheritdoc
     */
    /*
    public function execute($user, $item, $params)
    {
        $routeParams = isset($item->data['params']) ? $item->data['params'] : [];
        $allow = true;
        $queryParams = \Yii::$app->request->getQueryParams();
        foreach ($routeParams as $key => $value) {
            $allow = $allow && (!isset($queryParams[$key]) || $queryParams[$key]==$value);
        }

        return $allow;
    }
    */
}
