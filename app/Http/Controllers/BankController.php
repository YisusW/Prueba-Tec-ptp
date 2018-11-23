<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\BankList;
use PlaceToPay\Bank;
use PlaceToPay\Http\Controllers\PersonController;
use PlaceToPay\Http\Controllers\Transaction;
use PlaceToPay\Http\Controllers\PlaceToPay\Soap;

class BankController extends Controller
{
    /**
     *
     *  @return Class
     **/
    public function getModel()
    {
         return new \PlaceToPay\Bank();
    }

    /**
     *
     *  @return Class
     **/
    private function getClassPersonController()
    {
         return new PersonController;
    }
    /**
     *  Obtener unos parametros para hacer la peticion de la transaccion a place tp pay
     *  @return redirect
     */
    public function index(Request $request, $id_comprador = null, $id_pagador = null)
    {
        $data = (object) array('comprador' => $id_comprador , 'pagador' => $id_pagador);
        return view('bankList')->with(compact('data',$data));
    }

    /**
     *    get list of banks with web services Soap
     *  @return object
     */
    public function getBankList(Request $request)
    {
        if ($request->ajax()) {

           $service = new PlaceToPay\BankList;

            $list_banks = (object) $service->listBank();
            if ( $list_banks->result == true ) {
                return response()->json( array('result'=> 1, 'data'=> $list_banks->data  ) );
            } elseif ( $list_banks->result == false ){
                return response()->json( array('result'=> 0, 'message'=> $list_banks->message  ) );
            }
        }
        return (object) $service->listBank();
    }

    /**
     *
     * @return boolean-colecction
     */
    public function store(Request $request,Bank $bank,Soap $soap)
    {
          $bank = $this->getModel();

          $banco = $this->saveBank($bank, (object) $request->all());

          if ($banco == false) {
              return response()->json(array('result' => 0 , 'message' => 'No se pudo registrar el formulario' ));
          } else {
              $pagador = $this->getPerson($request->pagador)->toArray();
              $comprador = $this->getPerson($request->comprador)->toArray();
              $banco->type_client = TypeClientController::getTypeClient($banco->type_client_id);
              $transaction_info = Transaction::createTransaction($pagador, $comprador, $banco);

              $respuesta = $soap->createTransaction($transaction_info);

              if ( $respuesta && isset($respuesta->createTransactionResult) ) {
                  $datos = Transaction::saveResponseTransaction($request->pagador, $request->comprador, $banco->id, $respuesta->createTransactionResult);

                  $response = array('result' => 1 ,
                  'url' => $respuesta->createTransactionResult->bankURL,
                  'message' => $respuesta->createTransactionResult->responseReasonText,
                  'transactionId' => $respuesta->createTransactionResult->transactionID
                   );

                  return response()->json($response);

              } else {
                  return response()->json(array('result' => 0 , 'message' => 'No se pudo registrar el formulario' ));
              }
          }

          return ($bank->save()) ? $bank : false ;
    }


    /**
     * funcion que se encarga de registrar el bango datos básicos
     * @return boolean-colecction
     **/
     private function saveBank($bank, $datos)
     {
           $bank->type_client_id = $datos->tipo_cliente;
           $bank->code_bank = $datos->bank_code;
           $bank->method_pay = $datos->method_pay;
           $bank->money = $datos->mount;
           $bank->status = 1;
           return ($bank->save()) ? $bank : false ;
     }

     /**
      * buscar las personas pagador y comprador
      * @return object
      */

      private function getPerson( $id_persona )
      {
          return $this->getClassPersonController()->getPersonById($id_persona);
      }

      /**
       *
       *
       */
      public function statusTransaction(Request $request, Soap $place_t_pay)
      {
           $result = $place_t_pay->getTransactionInformation($request->transaction_id);

           if( $result->getTransactionInformationResult ){
          /*

          +"transactionID": 1464575807
          +"sessionID": "e054d927fe3e393d5a65a29685eb887b"
          +"reference": "Referencia única de pago"
          +"requestDate": "2018-11-23T06:22:39-05:00"
          +"bankProcessDate": "2018-11-23T06:24:45-05:00"
          +"onTest": true
          +"returnCode": "SUCCESS"
          +"trazabilityCode": "1497088"
          +"transactionCycle": 1
          +"transactionState": "OK"
          +"responseCode": 1
          +"responseReasonCode": "00"
          +"responseReasonText": "Aprobada"
          */

              return response()->json(array('result' => 1, 'data' => $result->getTransactionInformationResult ));
           } else {
              return response()->json(array('result' => 0, 'message' => 'ocurrio un error en el servidor ' ));
           }
      }
}
