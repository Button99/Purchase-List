<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListTestCase extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function createList()
    {        
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function deleteList() {

    }

    public function updateList() {
        
    }

    public function readList() {

    }
}
