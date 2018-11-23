<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\City;

class CityController extends Controller
{
    //

    public function listCitiesActive( )
    {
          return City::where('status',1)->get(["id","description"]);
    }

    public function getCitiesByState( $state_id )
    {
          return City::where('status',1)->where('state_id' , $state_id)->get(["id","description"]);
    }
    /**
     *
     *  function que retorna la lista de ciudades segun un departamento seleccionado a el componente vue
     *
     */
    public function getListCityByState(Request $request, $id_state )
    {
         if ($request->ajax()) {
             return response()->json( array('result'=>1,'data'=>$this->getCitiesByState($id_state)) );
         } else {
             return $this->getCitiesByState($id_state);
         }
    }
    /**
     *
     *
     *
     */
    public function getCityById( $id )
    {
          $city = City::where('id' , $id)->get(["id" ,"description", "state_id"])->first();
          return ( $city ) ? $city : false ;
    }

    public function checkCity( $description , $id_state )
    {
         $city = City::where('state_id', $id_state)
         ->where('description' , $description)
         ->get()
         ->first();
         return ( $city ) ? true : false ;
    }

    public function pushCity( $description , $id_state )
    {
         $city = new City;
         $city->description = $description;
         $city->status = 1;
         $city->state_id = $id_state;
         return ( $city->save() ) ? true : false ;
    }
}
