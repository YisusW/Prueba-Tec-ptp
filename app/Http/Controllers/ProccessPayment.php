<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProccessPayment extends Controller
{
    public function getBankList()
    {
        $soap = new PlaceToPay\Soap();
        $list_banks = $soap->getBankList();
        return response()->json( array('result'=> 1, 'data'=> $list_banks  ) );
    }
    //
    public function store( Request $request )
    {
        if ($request->ajax()) {
            $soap = new PlaceToPay\Soap();
            $response = $soap->init();
            return response()->json( array('status'=> true, 'message'=> $response ) );
        } else {
           return response()->json(array( 'status' => false, 'message' => 'peticion no permitida' ));
        }
    }
}
