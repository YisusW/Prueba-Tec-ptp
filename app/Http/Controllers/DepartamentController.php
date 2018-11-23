<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\Departament;

class DepartamentController extends Controller
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

    public function checkDepartament( $description , $id_country )
    {
          $departament = Departament::where('country_id' ,$id_country )
          ->where('description',$description)->get()->first();
          return ( $departament ) ? false : true ;
    }

    public function pushDepartament( $description , $id_country )
    {
          //if ( $this->checkDepartament( $description , $id_country ) == false ) : return false; endif;

          $departament = new Departament;
          $departament->country_id = $id_country;
          $departament->description = $description;
          $departament->status = 1;
          return ( $departament->save() ) ? true : false;
    }

    public function getLastId(){
          return Departament::get()->last();
    }

    /**
    * obtener el nombre del departamento
    * @return string
    **/

    public static function getDepartament($Id)
    {
         return Departament::where("id" ,$Id)->get(["description"])->first()->description;
    }
}
