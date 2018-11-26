<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PlaceToPay\Jobs\SondaPlaceToPay;
use PlaceToPay\Http\Controllers\PlaceToPay\Soap;

class SondaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    /**
     *
     * @return test
     */
    public function testSondaTransaction()
    {
       $soap = new Soap;
       SondaPlaceToPay::dispatch($soap);
       $this->assertTrue(true);
    }
}
