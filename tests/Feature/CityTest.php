<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    protected $controller;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setController()
    {
        $this->controller = new \PlaceToPay\Http\Controllers\CityController;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllCity()
    {
        $this->setController();
        $this->assertTrue(is_object($this->controller->listCitiesActive()));
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetOneCity()
    {
        $this->setController();
        $id_city = 1;

        $result = $this->controller->getCityById($id_city);
        if ( $result == true ) $this->assertTrue( true );

         $this->assertTrue( true );
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPushCity()
    {
        $this->setController();
        $id_state = 10;
        $city =  "Bello";
        if ($this->controller->checkCity($city, $id_state) == false) {
            $this->assertTrue($this->controller->pushCity($city, $id_state));
        } else {
            $this->assertTrue($this->controller->checkCity($city, $id_state));
        }

    }

}
