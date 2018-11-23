<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\TypeClient;

class TypeClientController extends Controller
{
    /**
     * servicio que lista los tipos de clientes
     * @return json
     */
    public function listTypeListActive(Request $request, TypeClient $type_client)
    {
        if ($request->ajax()) {
            return response()->json(array('result' => 1, 'data' => $this->getTypeClientListActive($type_client) ));
        } else {
            return response()->json(array('result' => 1, 'data' => $this->getTypeClientListActive($type_client) ));
        }
    }

    /**
     *  Listar los
     * @return collection
     */
    public function getTypeClientListActive($type_client)
    {
        return $type_client->where('status',1)->get(["id","description"]);
    }
    /**
     *  obtener tipo de cliente en especifico
     * @return string
     */
    public static function getTypeClient($id)
    {
        return TypeClient::where('id',$id)->get(["description"])->first()->description;
    }
}
