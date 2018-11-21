<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    protected $controller ;
    /**
     * Se configura la variable controlador para que quede asociadoa la classe RoleController
     * @return void
     */

    /**
     * A basic getroles function.
     *
     * @return void
     */
    private function setController(){
       $this->controller = new \PlaceToPay\Http\Controllers\RoleController;
    }
    /**
     * A basic getroles function.
     *
     * @return void
     */
    public function testGetroles()
    {   $this->setController();
        $this->assertTrue(is_object($this->controller->getRoleActive()));
    }
    /**
     * A basic getroles function.
     *
     * @return void
     */
    public function testPushrole()
    {
        $this->setController();
        $this->assertTrue($this->controller->storeRole(null, 'Otros') == true);

    }
    /**
     * A basic getroles function.
     *
     * @return void
     */
    public function testCheckrole()
    {
        $this->setController();
        $this->assertFalse($this->controller->storeRole(null, 'Otros') == true);
    }
}
