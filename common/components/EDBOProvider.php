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
    private $_appKey = '';
    private $_EDBOGuides = NULL;
    private $_hostEDBOGuides = "http://10.22.22.129:8080/EDBOGuides/EDBOGuides.asmx?WSDL";
    private $_hostEDBOPerson = "http://10.22.22.129:8080/EDBOPerson/EDBOPerson.asmx?WSDL";

    public function init(){
        parent::init();
        
    }

    /*
    * appKey
    */
    public function getAppKey() 
    {
        return $this->_appKey;
    }
    public function setAppKey($value)
    {
        $this->_appKey = $value;
    }

    /*
    *
    */
    public function getHostEDBOGuides()
    {
        return $this->_hostEDBOGuides;
    }
    public function setHostEDBOGuides($value)
    {
        $this->_hostEDBOGuides = $value;
    }

    /*
    *
    */
    public function getHostEDBOPerson()
    {
        return $this->_hostEDBOPerson;
    }
    public function setHostEDBOPerson($value)
    {
        $this->_hostEDBOPerson = $value;
    }

    

    public function info(){
        $info = "<div>EDBO:</div>
        <div>appKey - $this->appKey</div>
        <div>hostEDBOGuides - $this->hostEDBOGuides</div>
        <div>hostEDBOPerson - $this->hostEDBOPerson</div>
        <p></p>". $this->EDBOGuides->info();


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
