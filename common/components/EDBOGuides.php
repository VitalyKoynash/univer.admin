<?php

namespace common\components;

use Yii;
use yii\base\Component;
//use yii\base\Event;
use common\components\EDBOSoapHelper;

/**
 * 
 *
 * @author Vitaly Koynash <vitaly.koynash@gmail.com>
 * @since 1.0
 */
class EDBOGuides extends Component
{
    private $_soap = NULL; // EDBOSOapHelper
    private $_try_init_flag = false; // флаг, сигнализирующий, что была попытка инициализировать SOAP

    
    private function check_soap_initialize(){

        if ($this->_try_init_flag && is_null($this->_soap)) // CHECK SOAP ERROR
            return FALSE;
        
        $this->_try_init_flag = TRUE; // ставим флаг попытки инициализации

        $soap_address = \Yii::$app->edbo->hostEDBOGuides;
        if (is_null($this->_soap))
            $this->_soap = new EDBOSoapHelper($soap_address);
        
        if (!$this->_soap->status) {
            $this->_soap = NULL;
            return FALSE;
        }
        return TRUE;
    }

    public function info(){
        return "status connection - ".($this->status ? 'succesfully' : 'failed');
    }

    public function getStatus() {
        return $this->check_soap_initialize();
    }

    public function getSoap() {
        $this->check_soap_initialize();
        return $this->_soap;
    }
        
    
    public function test() {
        return [
            function(){$res = $this->Login();  return print_r($res, true);},
            function(){$res = $this->LanguagesGet();  return print_r($res, true);},
            function(){$res = $this->GetLastError();  return print_r($res, true);},
            function(){$res = $this->GlobaliInfoGet();  return print_r($res, true);},
            function(){$res = $this->KOATUUGetL1();  return print_r($res, true);},
            function(){$res = $this->UniversitiesGet();  return print_r($res, true);},
            //function(){$res = count(\Yii::$app->user->identity->getEdbouser()->getEDBOUsers(2));  return print_r($res, true);},
            //function(){$res = (\Yii::$app->user->identity->getEdbouser()->getEDBOUsers(2));  return print_r($res, true);},
        ];
    }

//c5e74305-b5ab-4b4a-940c-cbe631b1b92e 

    /*
    * Регистрация нового пользователя на  web  сервисе
    */
    // parameters: string  User,  string Password,  
    // int ClearPreviewSession, string  ApplicationKey
    // result: string GUID сессии пользователя 
    /*
     * В случае успеха, метод возвращает GUID сессии пользователя ,  который используется при 
вызове всех последующих методов.  Возвращаемый идентификатор имеет 
фиксированный размер  в 36 байт,  (например  4FD18E5D-AAF7-4522-84D6-03AC56C35D2F).
В случае ошибки,  метод возвращает строку с кодом и описанием ошибки. 
Ошибочным считается вызов метода,  который возвращает строку  длинной  не равной  36-и
байтам. 
    */
    public function Login($User = NULL, $Password = NULL, $remembe = true) {

        if (is_null($Password))
            $Password = \Yii::$app->user->identity->getEdbouser()->getEDBOPassword();
        
        if (is_null($User))
            $User = \Yii::$app->user->identity->getEdbouser('email');
        
        $GUIDSession = \Yii::$app->user->identity->getGUIDSession();

        if ($remembe && EDBOSoapHelper::check_guid($GUIDSession))
        {
            \Yii::trace(__METHOD__.' guid found = '.$GUIDSession);
            return $GUIDSession;
        } 

        \Yii::trace(__METHOD__.' guid not found = '.$GUIDSession);
        //\Yii::$app->session->set('sessionId','');
        if (!$this->status) {
            \Yii::trace(__METHOD__.' guid not init - soap error !!! ');
            return NULL;
        }

        $ApplicationKey = Yii::$app->edbo->applicationKey;
        $ClearPreviewSession = Yii::$app->edbo->clearPreviewSession;
       
        $res = $this->soap->invoke ("Login", array (
                "User" => $User ,
                "Password"=>$Password, 
                "ClearPreviewSession"=>$ClearPreviewSession,
                "ApplicationKey"=>$ApplicationKey));

        if (!$res['status'])
        {
            \Yii::trace(__METHOD__.' failed getting guid = '.$GUIDSession);
            return NULL;
        }
        //\Yii::$app->session->set('sessionId','');
        \Yii::$app->user->identity->setGUIDSession($res['res']);

        $GUIDSession = \Yii::$app->user->identity->getGUIDSession();
        
        \Yii::trace(__METHOD__.' created guid = '.$GUIDSession);
        
        return $GUIDSession;

/*
            $languages = $this->soap->invoke("LanguagesGet", array("SessionGUID"=>$this->sessionId));

            print_r($languages);
        } else {
            echo '</br>session ID</br>';
            print $this->sessionId;
        }*/
    }


    public function Logout ($SessionGUID = NULL) {
        if (is_null($SessionGUID))
            $SessionGUID = $this->Login();

        $edbouser = \Yii::$app->user->identity->getEdbouser();
        \Yii::trace(__METHOD__,Yii::$app->user->identity->username);
        if (!is_null($edbouser))
        {
            if (Yii::$app->user->identity->username == 'admin') {
                //$edbouser->password = NULL;            
                $edbouser->sessionguid = NULL;
                $edbouser->save();
            }  else {
                //check multiply users connected by edbuuser
                if (count(\Yii::$app->user->identity->getEdbouser()->getEDBOUsers(2)) <= 1)
                {
                    $edbouser->sessionguid = NULL;
                    $edbouser->save();
                }
            }

            
            
        }

        //return;
        
        $res = $this->soap->invoke ( "Logout", array (
                "SessionGUID" => $SessionGUID));
            
        if (strlen($res['res']) == 0)
            return TRUE;

        return $res['res'];
    }
    
    /*
     * Получения списка доступных языков используемых ЄДЕБО
     */
    public function LanguagesGet($SessionGUID = NULL) {
        
        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

         $res = $this->soap->invoke ( "LanguagesGet", array (
                "SessionGUID" => $SessionGUID));
        
        return $res;

        if (isset($res['res']) && isset( $res['res']['dLanguages']))
            return $res['res']['dLanguages'];


        return NULL;
    }

        /*
    * Получение информации об ошибке при неудачном вызове всех методов web  сервиса, кроме  Login и Logout.
    */
    public function GetLastError($SessionGUID = NULL) {

        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        $res = $this->soap->invoke ( "GetLastError", array (
                "GUIDSession" => $SessionGUID));
        /*
        if ($res == NULL) {
            //error getting error
            $res = $this->soap->invoke ( "GetLastError", array (
                "SessionGUID" => $GUIDSession));
            if ($res == NULL) {
                return "Unknow EDBO error";
            }

        }
        */
        return $res;
        if (isset($res['res']) && isset( $res['res']['dLastError']))
            return $res['res']['dLastError'];
        return NULL;
    }

        /*
     * Получения информации о системе
     */
    public function  GlobaliInfoGet($SessionGUID = NULL) {
        $res = $this->_GlobaliInfoGet($SessionGUID);

        if (!is_null($res))
            return $res;

        if(!$this->Login(NULL, NULL, false)) 
            return NULL;

        return $this->_GlobaliInfoGet($SessionGUID);
    }

    public function  _GlobaliInfoGet($SessionGUID = NULL) {

        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;
        
         $res = $this->soap->invoke ( "GlobaliInfoGet", array (
                "SessionGUID" => $SessionGUID));

        //return is_null($res['res']);//['dGloabalInfo'];
        if ($res['res'] && array_key_exists('dGloabalInfo', $res['res']))
            return $res['res']['dGloabalInfo'];
        return NULL;
    }


    /*
    * Получения данных со справочника КОАТУУ  только 1-го уровня
    */
    public function  KOATUUGetL1($SessionGUID = NULL, $ActualDate = NULL, $Id_Language = NULL) {
        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        if (is_null($ActualDate))
            $ActualDate = EDBOSoapHelper::getDateNow();

        if (is_null($Id_Language))
            $Id_Language = 1;

        $res = $this->soap->invoke ( "KOATUUGetL1", array (
                "SessionGUID" => $SessionGUID,
                "ActualDate" => $ActualDate,
                "Id_Language" => $Id_Language      
                 )
                 );

        if ($res['res'] && array_key_exists('dKOATUU', $res['res']))
            return $res['res']['dKOATUU'];
        return NULL;
    }


     /*
     * UniversitiesGet
     */
    
    public function  UniversitiesGet($SessionGUID = NULL, $UniversityKode = '', 
            $Id_Language = NULL,  $ActualDate = NULL, $UniversityName = '') {

        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        if (is_null($ActualDate))
            $ActualDate = EDBOSoapHelper::getDateNow();

        if (is_null($Id_Language))
            $Id_Language = 1;

      $res = $this->soap->invoke ( "UniversitiesGet", array (
            "SessionGUID" => $SessionGUID,
            "UniversityKode" => $UniversityKode,
            "Id_Language" => $Id_Language, 
            "ActualDate" => $ActualDate, 
            "UniversityName" => $UniversityName,
            
            ));

        return $res;
        if ($res['res'] && array_key_exists('dKOATUU', $res['res']))
            return $res['res']['dKOATUU'];
        return NULL;
    }


}
