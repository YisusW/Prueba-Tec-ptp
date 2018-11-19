<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Transaction extends Controller
{
    //


      public function createTransaction( Request $request ){


        $tras = array('bankCode' => $request->bankCode,
        'bankInterface'  => $request->bankInterface ,
        'returnURL'      => 'https://registro.pse.com.co/PSEUserRegister/' ,
        'reference'      => 'Referencia única de pago',
        'description'    => 'pruebas desde yisus-dev',
        'language'       => 'es',
        'currency'       => 'COP',
        'totalAmount'    => (float)1000.0,
        'taxAmount'      => (float)500.0,
        'devolutionBase' => (float)250.0,
        'tipAmount'      => (float)250.0,
        'payer'          => $persona,
        'buyer'          => $persona,
        'shipping'       =>$persona,
        'ipAddress'      => "127.0.0.1" ,
        'userAgent'      => $_SERVER['HTTP_USER_AGENT'] );

      }

}
