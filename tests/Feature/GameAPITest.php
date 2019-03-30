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


    public function testMakeWinningMove(){
        $board=[
            ["X","X","O"],
            ["O","X","X"],
            ["O","X","O"]
        ];

        $faker=Factory::create();
        $response=$this->json('POST','/api/v1/move',[
            'board'=>$board,
            'player_id'=>1,
            'x'=>$faker->numberBetween(0,2),
            'y'=>$faker->numberBetween(0,2)
        ]);

        $response->assertStatus(200);

        $responseData=json_decode($response->content());
        Log::info($responseData->message);
    }


    public function testMakeEmptyMove(){
        $board=[
            ["X","","O"],
            ["O","",""],
            ["","","O"]
        ];

        $faker=Factory::create();
        $response=$this->json('POST','/api/v1/move',[
            'board'=>$board,
            'player_id'=>1,
            'x'=>$faker->numberBetween(0,2),
            'y'=>$faker->numberBetween(0,2)
        ]);

        $response->assertStatus(200);

        $responseData=json_decode($response->content());
        $this->assertTrue($responseData->success);
        $this->assertNotNull($responseData->data->board);
        $this->assertEquals('Your Turn...',$responseData->message);
        Log::info($responseData->message);
    }
}
