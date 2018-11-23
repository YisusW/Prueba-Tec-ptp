<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;

class ProccessPayment extends Controller
{

    //
    public function store( Request $request )
    {
        if ($request->ajax()) {
            $soap = new PlaceToPay\Soap();
            //$response = $soap->init();
            dd('procesar formulario');
            return response()->json( array('status'=> true, 'message'=> $response ) );
        } else {
           return response()->json(array( 'status' => false, 'message' => 'peticion no permitida' ));
        }
    }
    //
    public function bayerForm(Request $request)
    {
        return view('bayer');
    }
}
