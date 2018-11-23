<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\BankList;

class BankController extends Controller
{
    //
    public function index(Request $request, $id_comprador = null, $id_pagador = null)
    {
        $data = array('comprador' => $id_comprador , 'pagador' => $id_pagador);
        return view('bankList')->with('people',$data);
    }

    /**
     *    get list of banks
     *
     */
    public function getBankList(Request $request)
    {
        if ( $request->ajax() ) {

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
}
