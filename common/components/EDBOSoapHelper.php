<?php
namespace common\components;

use yii\base\Object;


/**
 * Soap for DEBO
 *
 * @author VItaly Koynash
 */
class EDBOSoapHelper extends Object 
{
    
    private $_soapClient ; // EDBOGuides or EDBOPerson
    private $_debug = \TRUE;
    //private $_status = \FALSE;
    private $_status_message = '';


    public function __construct($soap_address) {

        //$save_errlogin = ini_get('display_errors');
        //error_reporting('E_ALL');
        //\ob_start();

        //try {
            
            
            ini_set('display_errors','Off');
            
            if (function_exists('xdebug_disable')) {xdebug_disable();}
            
            //set_error_handler('my_custom_soap_wsdl_error_handler');

            

            try {
                
                $this->_soapClient = @new \SoapClient ($soap_address, array ('encoding'=>'utf-8',"exceptions" => true));
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
            if (function_exists('xdebug_enable')) {xdebug_enable();}
            return;
            
            //}catch (Exception $ex) {
               // $err = ob_get_contents();
                //header('Location: ./edbo-login.php?sessionId='.$err); 
            //    \Yii::warning("exception connect to ".$soap_address);
                //\ob_clean();
            //    return;
            //}

            //restore_error_handler();
            
            //if (function_exists('xdebug_enable')) {xdebug_enable();}
            

            //ini_set('display_errors',$save_errlogin);

            //\Yii::$app->session->set('soap','true');
            \Yii::info("succesfully connect to ".$soap_address);
            /*
        } catch (\SoapFault $ex) {
            if (function_exists('xdebug_enable')) {xdebug_enable();}
            //ini_set('display_errors',$save_errlogin);
            $this->_soapClient = NULL;
            $this->_status_message = $ex->faultstringgetMessage();
            \Yii::warning($this->_status_message);
            //\Yii::warning($ex->getMessage(), __METHOD__);
            //Yii::$app->session->set('soap','false');
            //Yii::$app->session->set('soap_info', $ex->getMessage());
            //throw $ex;
        }   
        */
        //\ob_clean();
        //
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

    public function invoke ($method, $params) {
        if (!$this->status) {
            return array('status' => FALSE,'message' => _status_message,'res' => NULL);
        }

        ob_start();
        $message = '';
        try {
                        
            $invs = $this->soapClient->__soapCall ($method, array($params));
            $sresult = $invs->{$method."Result"};
            $res = $this->buildObject($sresult);

            if ($this->debug) {
                $message .= '<div class="soap_debug">____________ result _____________</div>';
                print '<div class="soap_debug">';
                var_dump($res);
                print '</div>';
                $message = ob_get_clean() ;

            } else {
                ob_clean();
            }

            
            return array('status' => TRUE,'message' => $message,'res' => $res);
        } catch (\Exception $ex) {
            $message = $ex->getMessage() .'\n'.ob_get_clean() ;
            \Yii::warning($message);
            return array('status' => TRUE,'message' => $message,'res' => NULL);
            //if ($ex instanceof SoapFault OR $ex) {            }
            //print "Exception in try call method $method<br>\n";
            //print "Parameters:<br>\n";
            //print_r($params);
            //print "<br>\n";
            //throw $ex;
        }
    }
      
    private function buildObject($data) {

        $res = NULL;
        if (is_array($data) || is_object($data)) {
            $res = array();
            foreach ($data as $key => $value) {
                if (is_string($key)) {
                    switch (gettype($value)){
                        case "string":
                            //if ($this->debug == TRUE) print '<p class="soap_debug"> ['.$key.']  = '.$value.'</p>';
                            $res[$key] = $value;
                            break;
                        case "integer":
                            //if ($this->debug == TRUE) print '<p class="soap_debug"> ['.$key.']  = '.$value.'</p>';
                            $res[$key] = $value;
                            break;
                        case "int":
                            //if ($this->debug == TRUE) print '<p class="soap_debug"> ['.$key.']  = '.$value.'</p>';
                            $res[$key] = $value;
                            break;
                        case "any":
                            // xml
                            //if ($this->debug == TRUE) print '<p class="soap_debug"> ['.$key.']  = '.  htmlspecialchars($value).'</p>';
                            $res[$key] = simplexml_load_string("<?xml version=\"1.0\"?><document>".$value."</document>");
                            break;
                        default:
                            //if ($this->debug == TRUE) print '<p class="soap_debug">==== level down ====</p>';
                            //if ($this->debug == TRUE) print '<p class="soap_debug">['.$key.'] : '.gettype($value).'</p>';
                            $res[$key] = $this->buildObject($value);
                            break;
                    }
                } elseif (is_integer($key)) {
                    /*
                    if (gettype($value) != "object") {
                        if ($this->debug == TRUE) print '<p class="soap_debug"> ['.$key.']  = '.  htmlspecialchars($value).'</p>';
                    } else {
                        if ($this->debug == TRUE) print '<p class="soap_debug"> ['.$key.']  = {object} </p>';
                    }
                    */
                    $res[$key] = $this->buildObject($value);
                }
            }
        } else {
            $res = $data;
        }

        return $res;
    }

   
}
