<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;

class GameAPITest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testStartGame(){
        $faker=Factory::create();
        $fullname=$faker->firstName.' '.$faker->lastName;
        $response=$this->json('POST','/api/v1/start-game',[
            'email'=>$faker->email,
            'fullname'=>$fullname,
            'character'=>$faker->randomElement(['O','X'])
        ]);

        $response->assertStatus(201);
        $this->assertNotNull($response->content());
    }

    public function testStartGameWithEmptyValues(){

        $response=$this->json('POST','/api/v1/start-game',[
            'email'=>'',
            'fullname'=>'',
            'character'=>'X'
        ]);

        $response->assertStatus(400);
        $data=json_decode($response->content());
        $this->assertEquals(2,count($data->message));
        $this->assertFalse($data->success);
    }


    public function testStartGameWithSomeEmptyValues(){
        $faker=Factory::create();
        $response=$this->json('POST','/api/v1/start-game',[
            'email'=>$faker->unique()->email,
            'fullname'=>'',
            'character'=>'X'
        ]);

        $response->assertStatus(400);
        $data=json_decode($response->content());
        $this->assertEquals(1,count($data->message));
        $this->assertFalse($data->success);
    }


    public function testStartGameWithWrongCharacter(){
        $faker=Factory::create();
        $response=$this->json('POST','/api/v1/start-game',[
            'email'=>$faker->unique()->email,
            'fullname'=>$faker->firstName.' '.$faker->lastName,
            'character'=>'A'
        ]);

        $response->assertStatus(400);
        $data=json_decode($response->content());
        $this->assertEquals(1,count($data->message));
        $this->assertFalse($data->success);
        Log::info($data->message);
    }
}
