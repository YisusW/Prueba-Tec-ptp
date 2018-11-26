<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\Transaction as ResponseSoap;

class Transaction extends Controller
{
    protected static $model;
    /**
     *  Funcion que le da el formato oo estructura de como se envia la transaccion a PTP
     *  @return array
     */
    public static function createDataTransaction($buyer, $payer, $bank)
    {
         $bank->type_client = ($bank->type_client == 'Persona') ? 0 : 1 ;
         $payer = self::formatArray((object) $payer);
         $buyer = self::formatArray((object) $buyer);

         return array('bankCode' => $bank->code_bank,
        'bankInterface'  => $bank->type_client ,
        'returnURL'      => 'https://registro.pse.com.co/PSEUserRegister/' ,
        'reference'      => 'Prueba con datos de prueba',
        'description'    => 'Desarrollo Jesus Ochoa',
        'language'       => 'es',
        'currency'       => 'COP',
        'totalAmount'    => $bank->money,
        'taxAmount'      => self::calculateTax($bank->money),
        'devolutionBase' => 0,
        'tipAmount'      => 0,
        'payer'          => $payer,
        'buyer'          => $buyer,
        'shipping'       => $payer,
        'ipAddress'      => self::getIp() ,
        'userAgent'      => $_SERVER['HTTP_USER_AGENT'] );

    }

     /*
      *
      * function que se encarga de captar la direccion ip
      *
      */
     private static function getIp()
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
     /**
      *   Calcular el 19% de el monto mandado desde la interfaz
      *
      */
     private static function calculateTax( $money )
     {
          return number_format($money*0.19,2);
     }

     /**
      * solo se retorna un array con las key modificadas
      * @return array
      */
     public static function formatArray( $person )
     {
          return array(
            'document' => $person->document,
            'documentType' => $person->document_type,
            'firstName' => $person->first_name,
            'lastName' => $person->last_name,
            'company' => $person->company,
            'emailAddress' => $person->email,
            'address' => $person->address,
            'city' => $person->city,
            'province' => $person->province,
            'country' => $person->country,
            'phone' => $person->phone,
            'mobile' => $person->cell_phone
          );
     }

     /**
      *    Save Response of Place to Pay
      */
      public static function saveResponseTransaction($id_payer, $id_buyer, $id_bank ,$response_saop)
      {
            self::$model = new ResponseSoap;
            self::$model->payer_id         = $id_payer;
            self::$model->buyer_id         = $id_buyer;
            self::$model->bank_id          = $id_bank;
            self::$model->transaction_id   = $response_saop->transactionID;
            self::$model->session_id       = $response_saop->sessionID;
            self::$model->trazability_code = $response_saop->trazabilityCode;
            self::$model->status           = $response_saop->transactionState;

            return ( self::$model->save() ) ? self::$model : false ;
      }

}
