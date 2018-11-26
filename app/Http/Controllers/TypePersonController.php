<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\TypePerson;

class TypePersonController extends Controller
{

    /**
     *
     *  listar los tipos de personas si se hace la peticion por ejex retornar datos en formato json
     *  @return json | json (Collection)
     */
    public function getTypePersonList(Request $request)
    {
       if ($request->ajax()) {
          return response()->json(array('result'=>1,'data'=>$this->getTypePersonActive()));
       } else {
         return $this->getTypePersonActive();
       }
    }
    /**
     *
     *  Lista de los tipos de personas con status = 1
     *  @return object
     */
    public function getTypePersonActive()
    {
          return TypePerson::where('status' , 1)->get(["id","description"]);
    }
    /**
     *  verifica si el tipo de persona existe o
     *  @return boolean
     */
    public function checkTypePerson($description)
    {
         $result = TypePerson::where( 'description' , $description )->get()->first();
         return ( $result ) ? false : true ;
    }
    /**
     *  reigistra en la base de datos los
     * @return boolean
     */
    public function storeTypePerson($description = null)
    {
          if ( (!isset($request->description)) && ($description == null) ) : return false; endif;
          if (isset($request->description) && $this->checkTypePerson($request->description) == false) : return false; endif;
          if ( (! empty($description)) && ($this->checkTypePerson($description) == false) ) : return false; endif;
          $role = new TypePerson;
          $role->description = ( isset($request->description) ) ? $request->description : $description ;
          $role->status = 1;
          return ( $role->save() ) ? true : false ;
    }

    /**
     * funcion para registrar el tipo de persona haciendo peticiones desde el navegador
     * @return object
     */
    public function store(Request $request)
    {
         //validar datos entrantes y  luego registrar (Pendiente por hacer)
         return $this->storeTypePerson($request->description);
    }
}
