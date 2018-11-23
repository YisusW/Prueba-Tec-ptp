<?php

namespace PlaceToPay\Http\Controllers\PlaceToPay;

use Illuminate\Http\Request;
use PlaceToPay\Http\Controllers\Controller;
use Soap;
use \Cache;

class BankList extends Controller
{
    //
    public function listBank()
    {
        $this->checkListServicesCache();
    }
    /**
     *
     *    Verificar si la lista de los bacos estan en cache o no, para consumir el servicio
     *
     */
    public function checkListServicesCache(Soap $service)
    {
          $result = $this->verificar_service('bankDay');

          if ($result == false) {
              $result = $services->getBankList();
              if ($result == false) {
                  return array('result' => false, 'message' => 'Los datos no se encontraro' );
              } else {
                  return array('result' => true , 'data' => $result);
              }
          }

    }

    /**
     *
     *  Verificar cache key (BankList)
     *
     */
    public function verificar_service( $key )
    {
        return (Cache::has($key)) ;
    }

}
