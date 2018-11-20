<?php
namespace App\Http\Controllers\PlaceToPay;

use SoapClient;

class Soap
{
    protected static $Id = "6dd490faf9cb87a9862245da41170ff2";
    protected static $Key = "024h1IlD";
    protected $Wsdl = 'https://test.placetopay.com/soap/pse/?wsdl';
    private $point = '​https://test.placetopay.com/soap/pse/';
    /**
     *  Se especifica y se establecen los datos más importantes para conectar a el web service
     *
     */
    public function init()
    {
          $client = new SoapClient( $this->Wsdl );
          /* inconvenientet al llamar la variable $point (simplemente muestra mensaje Unable to parse URL)*/
          $client->__setLocation('https://test.placetopay.com/soap/pse/');
          return $client;
    }
    /**
     *      Parametros de autenticacion para conectar a el web services de place to pay.
     *
     */
    private function getAuth()
    {
          $date = date('c');
          $tranKey = sha1( $date . self::$Key  );
          return array('login' => self::$Id, 'tranKey' => $tranKey, 'seed' =>  $date ) ;
    }
    /**
    *
    * Listar los bancos que se deben mostrar en una vista
    *
    */
    public function getBankList()
    {
          $client = $this->init();
          /* la version de laravel me oblica a parsear a object u otro tipo de dato, en este caso se pasa a json */

          $result = $client->getBankList(array('auth' => $this->getAuth())) ;

          if (isset($result->getBankListResult)) {
             return $result->getBankListResult->item ;
          } else {
             return false ;
          }
    }
    /**
     *    Crear La transaction
     *    @ retorna
     **/
    public function createTransaction ( $transaction )
    {
          $client = $this->init();
          $trans_auth = array('auth' => $this->getAuth(), 'transaction'=>$transaction);
          return $client->createTransaction($trans_auth);
    }

}
