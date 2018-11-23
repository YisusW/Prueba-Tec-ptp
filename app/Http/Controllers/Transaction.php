<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;

class Transaction extends Controller
{
    //


      public function createTransaction( $buyer, $payer, $bank  )
      {
         return array('bankCode' => $bank->bankCode,
        'bankInterface'  => $bank->bankInterface ,
        'returnURL'      => 'https://registro.pse.com.co/PSEUserRegister/' ,
        'reference'      => 'Referencia única de pago',
        'description'    => 'pruebas desde yisus-dev',
        'language'       => 'es',
        'currency'       => 'COP',
        'totalAmount'    => 0,
        'taxAmount'      => 0,
        'devolutionBase' => 0,
        'tipAmount'      => 0,
        'payer'          => $payer,
        'buyer'          => $buyer,
        'shipping'       => $persona,
        'ipAddress'      => $this->getIp() ,
        'userAgent'      => $_SERVER['HTTP_USER_AGENT'] );

      }

     /*
      *
      * function que se encarga de captar la direccion ip
      *
      */
     private function getIp()
     {
           if (isset($_SERVER["HTTP_CLIENT_IP"])) {
               return $_SERVER["HTTP_CLIENT_IP"];
           } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
               return $_SERVER["HTTP_X_FORWARDED_FOR"];
           } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
               return $_SERVER["HTTP_X_FORWARDED"];
           } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
               return $_SERVER["HTTP_FORWARDED_FOR"];
           } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
               return $_SERVER["HTTP_FORWARDED"];
           } else {
               return $_SERVER["REMOTE_ADDR"];
           }
     }

}
