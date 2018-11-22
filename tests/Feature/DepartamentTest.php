<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartamentTest extends TestCase
{

	protected $controller ;

	public function setController()
	{
		  $this->controller = new \PlaceToPay\Http\Controllers\DepartamentContoller;
	}

  /**
   * A basic test example.
   *
   * @return void
   */
  public function testGetDepartamentsActive()
  {
      $this->setController();
      $this->assertTrue( is_object( $this->controller->getDepartamentsActive() ) );
  }
	/**
 	 *  Registrar un departamento
	 *
	 */
	public function testPushDepartament()
	{
		  $this->setController();

			$country = 1;
			$state = "Antioquia";

			if ($this->controller->checkDepartament($state, $country) == true) {

				  $this->assertTrue( $this->controller->pushDepartament( $state, $country ) );
			}else{
					$this->assertFalse( false );
			}
	}
}
