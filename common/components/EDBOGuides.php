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
        return $this->_soap;
    }
        
    
    /*
    * Получение информации об ошибке при неудачном вызове всех методов web  сервиса, кроме  Login и Logout.
    */
    public function GetLastError($GUIDSession) {
        $res = $this->soap->invoke ( "GetLastError", array (
                "GUIDSession" => $GUIDSession));

        if ($res == NULL) {
            //error getting error
            $res = $this->soap->invoke ( "GetLastError", array (
                "SessionGUID" => $SessionGUID));
            if ($res == NULL) {
                return "Unknow EDBO error";
            }

        }
        return $res;
    }


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
    public function Login($User, $Password ) {
        
        \Yii::$app->session->set('sessionId','');
        if (!$this->status) return NULL;

        $ApplicationKey = Yii::$app->edbo->applicationKey;
        $ClearPreviewSession = Yii::$app->edbo->clearPreviewSession;
       
        $res = $this->soap->invoke ("Login", array (
                "User" => $User ,
                "Password"=>$Password, 
                "ClearPreviewSession"=>$ClearPreviewSession,
                "ApplicationKey"=>$ApplicationKey));

        if (!$res['status'])
            return NULL;
        \Yii::$app->session->set('sessionId','');
        return $sessionId;

/*
            $languages = $this->soap->invoke("LanguagesGet", array("SessionGUID"=>$this->sessionId));

            print_r($languages);
        } else {
            echo '</br>session ID</br>';
            print $this->sessionId;
        }*/
    }
    
    /*
     * Получения списка доступных языков используемых ЄДЕБО
     */
    public function LanguagesGet($SessionGUID) {
         $res = $this->soap->invoke ( "LanguagesGet", array (
                "SessionGUID" => $SessionGUID));

        return $res;
    }



}
