<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\BankList;
use PlaceToPay\Bank;
use PlaceToPay\Http\Controllers\PersonController;

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
    public function store(Request $request,Bank $bank)
    {
          $bank = $this->getModel();

          $result = $this->saveBank($bank, (object) $request->all());

          if ($result == false) {
              return response()->json(array('result' => 0 , 'message' => 'No se pudo registrar el formulario' ));
          } else {
              $pagador = $this->getPerson($request->pagador);
              $comprador = $this->getPerson($request->comprador);
              $banco = $result;
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
           $bank->status = 1;
           return ($bank->save()) ? true : false ;
     }

     /**
      * buscar las personas pagador y comprador
      * @return object
      */

      private function getPerson( $id_persona )
      {
          return $this->getClassPersonController()->getPersonById($id_persona);
      }
}
