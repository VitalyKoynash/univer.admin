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
    private $_EDBOPerson = NULL;
    
/*
    public function info(){
        $info = 
        "<div>EDBO:</div>
        <div>applicationKey - $this->applicationKey</div>
        <div>hostEDBOGuides - $this->hostEDBOGuides</div>
        <div>hostEDBOPerson - $this->hostEDBOPerson</div>
        <p>". $this->EDBOGuides->info().'</p>';
        return $info;
    }
*/

    public function getEDBOGuides()
    {

        if (is_null($this->_EDBOGuides))
            $this->_EDBOGuides = new EDBOGuides();
        return $this->_EDBOGuides;
    }

    public function getEDBOPerson()
    {

        if (is_null($this->_EDBOPerson))
            $this->_EDBOPerson = new EDBOPerson();
        return $this->_EDBOPerson;
    }


    public function GetLastError($SessionGUID = NULL) {
        
        if (is_null($SessionGUID))
            if(!$SessionGUID = \Yii::$app->edbo->EDBOGuides->Login()) return NULL;

        $res = $this->soap->invoke ( "GetLastError", array (
                "GUIDSession" => $SessionGUID));

        return $this->getResult($res, 'dLastError');
        
    }


    public function getActualPersonRequestSeason($SessionGUID = NULL, $Id_Language = NULL) {
        return 4;
        $date_cur = date_create_from_format ("Y-m-d H:i:s",date("Y")."-07-15 23:59:59"); 
        $res = $this->PersonRequestSeasonsGet($sessionId, 
                $Id_Language, 
                getDateNow(), 
               0, 0, 1);
        $dPersonRequestSeasons = $res['dPersonRequestSeasons'];
        
        for ($i = 0; $i < count($dPersonRequestSeasons); $i++)
        {
            $item = $dPersonRequestSeasons[$i];
            $date_begin = date_create_from_format ("Y-m-d H:i:s",  str_replace("T"," ",$item['DateBeginPersonRequestSeason']));
            $date_end = date_create_from_format ("Y-m-d H:i:s", str_replace("T"," ",$item['DateEndPersonRequestSeason']));
            
            //print $date_begin->format('Y-m-d').' '.$date_end->format('Y-m-d').'  '.$date_cur->format('Y-m-d').'<br>';
            if (($date_begin <= $date_cur) && ($date_end >= $date_cur)) {
                return $dPersonRequestSeasons[$i]['Id_PersonRequestSeasons'];
            }
            
        }
        return 0;
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
