<?php
namespace common\components;

use yii\base\Object;
//use yii\base\ErrorException;

/**
 * Soap for DEBO
 *
 * @author VItaly Koynash
 */
class EDBOSoapHelper extends Object 
{
    
    private $_soapClient ; // EDBOGuides or EDBOPerson
    private $_debug = TRUE;
    //private $_status = \FALSE;
    private $_status_message = '';


    public function __construct($soap_address) {

            try {
                \Yii::beginProfile('_soapClient');
                $this->_soapClient = new \SoapClient ($soap_address, [
                    'encoding'=>'utf-8',
                    "exceptions" => 1,
                    'cache_wsdl' => \WSDL_CACHE_MEMORY,
                    ]);
                \Yii::endProfile('_soapClient');
                \Yii::trace("succesfully connect to ".$soap_address);
             } catch (\SoapFault  $ex) { /*SoapFault*/
                
                //ini_set('display_errors',$save_errlogin);
                $this->_soapClient = NULL;
                $this->_status_message = $ex->faultstring;//getMessage()
                \Yii::warning($this->_status_message);
                //\Yii::warning($ex->getMessage(), __METHOD__);
                //Yii::$app->session->set('soap','false');
                //Yii::$app->session->set('soap_info', $ex->getMessage());
                //throw $ex;
            }   

    }

    public function getDebug(){
        return $this->_debug;
    }
    public function setDebug($value){
        $this->_debug = $value;
    }

    public function getSoapClient(){
        return $this->_soapClient;
    }
   

    /*
    * 
    */
    public function getStatus() {
        if (is_null($this->_soapClient)) {
            return \FALSE;
        }
        return \TRUE;
    }


    private function buildObject($data) {

        if (!(is_array($data) || is_object($data) || is_null($data))) return $data;

        $res = array();
        foreach ($data as $key => $value) {
            switch (gettype($value)){
                case "string":
                    $res[$key] = $value; break;
                case "integer":
                    $res[$key] = $value; break;
                case "int":
                    $res[$key] = $value; break;
                case "any":
                    $res[$key] = simplexml_load_string("<?xml version=\"1.0\"?><document>".$value."</document>"); break;
                default:
                    $res[$key] = $this->buildObject($value);  break;
            }
        }
        return $res;
    }

    public function invoke ($method, $params) {
        
        $res = array('status' => FALSE,'message' => $this->_status_message,'res' => NULL, 'soap' => NULL);
        
        if (!$this->status) return  $res;

        if ($this->debug)
            \Yii::beginProfile($method);
        
        $message = '';
        try {
                        
            $invs = $this->soapClient->__soapCall ($method, array($params));
            $result_from_soap = $invs->{$method."Result"};
            $result = $this->buildObject($result_from_soap);

            /*
            if ($this->debug) {
                ob_start();
                echo '<div class="soap_debug">____________ result _____________</div>';
                echo '<div class="soap_debug">';
                var_dump($res);
                echo '</div>';
                $message = ob_get_clean() ;

            } 
            */

            $res['status'] = TRUE;
            $res['message'] = $message;
            $res['res'] = $result;
            //$res['soap'] = $result_from_soap;
            
        } catch (\Exception $ex) {
            
            $message = $ex->getMessage() .'\n'.ob_get_clean() ;
            
            \Yii::warning($message);
            
            $res['status'] = FALSE;
            $res['message'] = $message;
        }
        if ($this->debug)
            \Yii::endProfile($method);
        return $res;
    }


    static public function check_guid ($sessionId) {
        if (is_null($sessionId)) {
            return FALSE;
        }
        return preg_match("/([a-f\d]{8})-([a-f\d]{4})-([a-f\d]{4})-([a-f\d]{4})-([a-f\d]{12})/i", $sessionId)==0?FALSE:TRUE;
    }

    static public function getDateNow () {
        return date ("d.m.Y h:i:s");
    }
      

}
