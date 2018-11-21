<?php

namespace PlaceToPay\Http\Controllers;

use Illuminate\Http\Request;
use PlaceToPay\Role;

class RoleController extends Controller
{

    public function roleList()
    {
          return response()->json(array('result'=>1, 'data'=>$this->getRoleActive()));
    }
    //
    public function getRoleActive()
    {
          return Role::where('status' , 1)->get(["id","description"]);
    }

    public function checkRole($description)
    {
         $result = Role::where( 'description' , $description )->get()->first();
         return ( $result ) ? false : true ;
    }

    public function storeRole(Request $request =  null, $description = null)
    {
          if ( (!isset($request->description)) && ($description == null) ) : return false; endif;
          if (isset($request->description) && $this->checkRole($request->description) == false) : return false; endif;
          if ( (! empty($description)) && ($this->checkRole($description) == false) ) : return false; endif;
          $role = new Role;
          $role->description = ( isset($request->description) ) ? $request->description : $description ;
          $role->status = 1;
          return ( $role->save() ) ? $role : false ;
    }
}
