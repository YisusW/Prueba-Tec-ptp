<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypePersonTest extends TestCase
{
    protected $controller ;
    /**
     * Se configura la variable controlador para que quede asociadoa la classe RoleController
     * @return void
     */
    private function setController(){
        $this->controller = new \PlaceToPay\Http\Controllers\TypePersonController;
    }
    /**
     * A basic getroles function.
     *
     * @return void
     */
    public function testGetTypePerson()
    {   $this->setController();
        $this->assertTrue(is_object($this->controller->getTypePersonActive()));
    }
    /**
     * A basic getroles function.
     *
     * @return void
     */
    public function testPushTypePerson()
    {
        $this->setController();

        $result = $this->controller->checkTypePerson('Otros');

        if ( $result == true ) {
            $this->assertTrue($this->controller->storeTypePerson('Otros') == true);
        } else {
            $this->assertFalse($result);
        }

    }
    /**
     * A basic getroles function.
     *
     * @return void
     */
    public function testCheckTypePerson()
    {
        $this->setController();
        $this->assertFalse($this->controller->checkTypePerson('Otros') == true);
    }
}
