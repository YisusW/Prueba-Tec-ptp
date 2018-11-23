<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\Person;

class PersonController extends Controller
{
    /**
     *
     * Cuando se registra un comprador se el envia una url a el fron para cuando se hace click se muestra otro formulario
     * @return view
     */
    public function formPayer(Request $request, $id_comprador)
    {
          return view('payer')->with('id_comprador',$id_comprador);
    }

    /**
     *  Evaluar si el registro se ahce correctamente o no, para retornar un array
     *  @return json
     */
    public function store(Request $request, Person $person)
    {
          if( $this->checkDocument($person, (object) $request->all() ) == false )
              return response()->json( array('result' => 0, 'message' => 'El documento de identidad ya se encuentra registrado' ) );

          $result = $this->save($person, (object) $request->all());

          if ($result !== false) {
             return response()->json( array('result' => 1, 'data' => $result) );
          } else {
             return response()->json( array('result' => 0, 'message' => 'El registro no se completó correctamente' ) );
          }
    }
    /**
     * esta funcion retornara una coleccion en caso de registrar y false en caso de no
     * @return object | boolean
     */
    public function save($person, $datos)
    {
          $person->city_id        = $datos->city;
          $person->type_person_id = $datos->type_person;
          $person->document       = $datos->documnet;
          $person->document_type  = $datos->type_document;
          $person->first_name     = $datos->nombre;
          $person->last_name      = $datos->apellido;
          $person->address        = $datos->address;
          $person->email          = $datos->email;
          $person->phone          = $datos->phone;
          $person->cell_phone     = $datos->mobile;
          $person->company        = $datos->company;
          return ($person->save()) ? $person : false ;
    }

    /**
     * verifica si existe una persona por medio del documeto de identidad
     * @return boolean
     */
    public function checkDocument( $person, $datos )
    {
          $result = $person->where('document',$datos->documnet)
          ->where('document_type' , $datos->type_document)
          ->get()
          ->first();
          return ( count((array)$result)>0 ) ? false : true ;
    }
}
