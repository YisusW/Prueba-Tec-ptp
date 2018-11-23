<?php

namespace PlaceToPay\Http\Controllers\PlaceToPay;

use PlaceToPay\Http\Controllers\PlaceToPay\Soap;
use \Cache;

class BankList
{

    protected $services ;

    public function __construct()
    {
        $this->services = new Soap();
    }


    /**
     *
     *    Verificar si la lista de los bacos estan en cache o no, para consumir el servicio
     *
     */
    public function listBank()
    {
          $result = $this->checkListOnCache('bankDay');

          if ($result == false) {
              $result = $this->services->getBankList();
              if ($result == false) {
                  return array('result' => false, 'message' => 'Los datos no se encontraro' );
              } else {

                  $this->setCacheBankList($result);

                  return array('result' => true , 'data' => $result);
              }
          } else {

            return array('result' => true , 'data' => $result);
          }

    }

    /**
     *
     *  Verificar cache key (BankList)
     *
     */
    public function checkListOnCache( $key )
    {
         return (Cache::has($key)) ;
    }

    /**
     *
     *  poner en cache la lista de  bancos
     *
     */

    private function setCacheBankList ($Bank)
    {
        $minutos = 1440;

   		  $Bank = Cache::remember( 'bankDay', $minutos, function () use ($Bank) {
   	    	return $Bank;
        });
     }

}
