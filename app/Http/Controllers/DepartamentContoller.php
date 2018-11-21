<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\Departament;

class DepartamentContoller extends Controller
{
    //

    public function getDepartamentsActive()
    {

    	return Departament::where('status' , 1)->get(["id" , "description"]);
    }

    public function listDepartaments(Request $request)
    {
    	    if ($request->ajax()) {

    	        return response()->json( array('result'=> 1, 'data'=> $this->getDepartamentsActive() ) );
    	    } else {

    	    	return $this->getDepartamentsActive();
    	    }
    }
}
